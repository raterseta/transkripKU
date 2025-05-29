<?php
namespace App\Services;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\RFCValidation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailValidationService
{
    private EmailValidator $validator;
    private array $disposableDomains;
    private array $riskyDomains;
    private array $roleBasedPrefixes;
    private bool $enableSmtpCheck;
    private int $smtpTimeout;

    public function __construct()
    {
        $this->validator = new EmailValidator();
        $this->loadDisposableDomains();
        $this->loadRiskyDomains();
        $this->loadRoleBasedPrefixes();

        $this->enableSmtpCheck = config('email_validation.smtp_check.enabled', false);
        $this->smtpTimeout     = config('email_validation.smtp_check.timeout', 5);
    }

    public function validateEmail(string $email): array
    {
        $email = strtolower(trim($email));

        $cacheKey = 'email_validation_' . md5($email);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $result = $this->performValidation($email);

        Cache::put($cacheKey, $result, now()->addHour());

        return $result;
    }

    private function performValidation(string $email): array
    {
        // Step 1: Basic syntax validation
        $rfcValidation = new RFCValidation();
        if (! $this->validator->isValid($email, $rfcValidation)) {
            return $this->createResult(false, 'invalid_syntax', 'Email format is invalid');
        }

        // Extract domain and local part
        $domain    = substr(strrchr($email, "@"), 1);
        $localPart = substr($email, 0, strrpos($email, '@'));

        // Step 2: Check for disposable/temporary email domains
        if ($this->isDisposableEmail($domain)) {
            return $this->createResult(false, 'disposable_email', 'Disposable email detected');
        }

        // Step 3: Check for risky domains
        if ($this->isRiskyDomain($domain)) {
            return $this->createResult(false, 'risky_domain', 'Risky domain detected');
        }

        // Step 4: Check for role-based emails
        if ($this->isRoleBasedEmail($localPart)) {
            return $this->createResult(false, 'role_based', 'Role-based email detected');
        }

        // Step 5: DNS MX record validation
        $dnsResult = $this->validateDNS($email, $domain);
        if (! $dnsResult['valid']) {
            return $this->createResult(false, $dnsResult['reason'], $dnsResult['details']);
        }

        // Step 6: SMTP Deliverability Check (optional)
        if ($this->enableSmtpCheck) {
            $deliverabilityResult = $this->checkEmailDeliverabilityWithTimeout($email, $domain, $dnsResult['mx_records'] ?? []);
            if (! $deliverabilityResult['deliverable'] && $deliverabilityResult['confident']) {
                return $this->createResult(false, $deliverabilityResult['reason'], $deliverabilityResult['details']);
            }
        } else {
            $deliverabilityResult = $this->performHeuristicCheck($email, $domain, $localPart);
            if (! $deliverabilityResult['deliverable']) {
                return $this->createResult(false, $deliverabilityResult['reason'], $deliverabilityResult['details']);
            }
        }

        // Step 7: Additional domain reputation check
        $reputationResult = $this->checkDomainReputation($domain);
        if (! $reputationResult['safe']) {
            Log::warning('Domain reputation check failed', [
                'domain' => $domain,
                'email'  => $email,
                'reason' => $reputationResult['reason'],
            ]);
        }

        return $this->createResult(true, 'valid', 'Email passed all validation checks', [
            'domain_reputation'    => $reputationResult,
            'mx_records_found'     => $dnsResult['mx_count'] ?? 0,
            'deliverability_check' => $deliverabilityResult ?? null,
        ]);
    }

    private function validateDNS(string $email, string $domain): array
    {
        try {
            $originalTimeout = ini_get('default_socket_timeout');
            ini_set('default_socket_timeout', $this->smtpTimeout);

            $mxRecords = dns_get_record($domain, DNS_MX);

            if (empty($mxRecords)) {
                $aRecords = dns_get_record($domain, DNS_A);
                if (empty($aRecords)) {
                    return ['valid' => false, 'reason' => 'no_mx_record', 'details' => 'No MX or A records found'];
                }
                $mxRecords = [['host' => $domain, 'pri' => 10]];
            }

            usort($mxRecords, function ($a, $b) {
                return $a['pri'] <=> $b['pri'];
            });

            try {
                $dnsValidation = new DNSCheckValidation();
                if (! $this->validator->isValid($email, $dnsValidation)) {
                    return ['valid' => false, 'reason' => 'dns_validation_failed', 'details' => 'DNS validation failed'];
                }
            } catch (\Exception $e) {
                Log::debug('DNS validation skipped due to timeout', ['domain' => $domain]);
            }

            ini_set('default_socket_timeout', $originalTimeout);

            return ['valid' => true, 'mx_count' => count($mxRecords), 'mx_records' => $mxRecords];

        } catch (\Exception $e) {
            if (isset($originalTimeout)) {
                ini_set('default_socket_timeout', $originalTimeout);
            }

            Log::warning('DNS validation failed', [
                'domain' => $domain,
                'error'  => $e->getMessage(),
            ]);

            return ['valid' => false, 'reason' => 'dns_error', 'details' => 'DNS lookup failed: ' . $e->getMessage()];
        }
    }

    private function checkEmailDeliverabilityWithTimeout(string $email, string $domain, array $mxRecords): array
    {
        $startTime        = time();
        $maxExecutionTime = $this->smtpTimeout;

        if (empty($mxRecords)) {
            $mxRecords = dns_get_record($domain, DNS_MX);
            if (empty($mxRecords)) {
                return [
                    'deliverable' => false,
                    'reason'      => 'no_mx_records',
                    'details'     => 'No MX records found for domain',
                    'confident'   => true,
                ];
            }
        }

        usort($mxRecords, function ($a, $b) {
            return $a['pri'] <=> $b['pri'];
        });

        $localPart = substr($email, 0, strrpos($email, '@'));

        if ($this->isInvalidLocalPart($localPart, $domain)) {
            return [
                'deliverable' => false,
                'reason'      => 'invalid_local_part',
                'details'     => 'Local part appears invalid',
                'confident'   => true,
            ];
        }

        foreach (array_slice($mxRecords, 0, 2) as $mxRecord) {
            if (time() - $startTime >= $maxExecutionTime) {
                Log::debug('SMTP check timeout reached', ['email' => $email]);
                break;
            }

            $mxHost = $mxRecord['host'] ?? $mxRecord['target'] ?? '';
            if (empty($mxHost)) {
                continue;
            }

            $smtpResult = $this->performSMTPCheckWithTimeout($email, $mxHost, $domain, $maxExecutionTime - (time() - $startTime));

            if ($smtpResult['checked']) {
                return [
                    'deliverable' => $smtpResult['deliverable'],
                    'reason'      => $smtpResult['reason'],
                    'details'     => $smtpResult['details'],
                    'mx_host'     => $mxHost,
                    'confident'   => true,
                ];
            }
        }

        // If SMTP check failed for all servers, perform heuristic check
        $heuristicResult              = $this->performHeuristicCheck($email, $domain, $localPart);
        $heuristicResult['confident'] = false;
        return $heuristicResult;
    }

    private function performSMTPCheckWithTimeout(string $email, string $mxHost, string $domain, int $remainingTime): array
    {
        if ($remainingTime <= 0) {
            return ['checked' => false, 'reason' => 'timeout_before_start'];
        }

        $socket  = null;
        $timeout = min($remainingTime, 3); // Max 3 seconds per connection

        try {
            $context = stream_context_create([
                'socket' => [
                    'timeout' => $timeout,
                ],
            ]);

            $mxIP = gethostbyname($mxHost);
            if ($mxIP === $mxHost) {
                return ['checked' => false, 'reason' => 'mx_resolve_failed'];
            }

            $errno  = $errstr  = null;
            $socket = @fsockopen($mxIP, 25, $errno, $errstr, $timeout);
            if (! $socket) {
                Log::debug('SMTP connection failed', [
                    'mx_host' => $mxHost,
                    'mx_ip'   => $mxIP,
                    'errno'   => $errno,
                    'errstr'  => $errstr,
                ]);
                return ['checked' => false, 'reason' => 'connection_failed'];
            }

            stream_set_timeout($socket, $timeout);

            $response = fgets($socket, 515);
            if (! $response || ! str_starts_with($response, '2')) {
                fclose($socket);
                return ['checked' => false, 'reason' => 'smtp_not_ready'];
            }

            $commands = [
                "HELO " . ($_SERVER['SERVER_NAME'] ?? 'localhost'),
                "MAIL FROM:<test@" . ($_SERVER['SERVER_NAME'] ?? 'localhost') . ">",
                "RCPT TO:<{$email}>",
            ];

            foreach ($commands as $command) {
                fputs($socket, $command . "\r\n");
                $response = fgets($socket, 515);

                if (! $response) {
                    fclose($socket);
                    return ['checked' => false, 'reason' => 'no_response'];
                }

                $responseCode = (int) substr($response, 0, 3);

                if (str_starts_with($command, 'RCPT TO:')) {
                    fputs($socket, "QUIT\r\n");
                    fclose($socket);

                    if ($responseCode >= 200 && $responseCode < 300) {
                        return [
                            'checked'       => true,
                            'deliverable'   => true,
                            'reason'        => 'smtp_accepted',
                            'details'       => 'SMTP server accepted the email address',
                            'response_code' => $responseCode,
                        ];
                    } elseif ($responseCode >= 500) {
                        return [
                            'checked'       => true,
                            'deliverable'   => false,
                            'reason'        => 'permanent_failure',
                            'details'       => 'SMTP server rejected the email address: ' . trim($response),
                            'response_code' => $responseCode,
                        ];
                    }
                }

                if (! str_starts_with($command, 'RCPT TO:') && $responseCode >= 400) {
                    fclose($socket);
                    return ['checked' => false, 'reason' => 'smtp_conversation_failed'];
                }
            }

        } catch (\Exception $e) {
            if ($socket) {
                @fclose($socket);
            }

            Log::debug('SMTP check exception', [
                'email'   => $email,
                'mx_host' => $mxHost,
                'error'   => $e->getMessage(),
            ]);

            return ['checked' => false, 'reason' => 'exception', 'error' => $e->getMessage()];
        } finally {
            if ($socket) {
                @fclose($socket);
            }
        }

        return ['checked' => false, 'reason' => 'unknown_error'];
    }

    private function isInvalidLocalPart(string $localPart, string $domain): bool
    {
        $invalidPatterns = [
            '/^test\d*$/',     // test, test1, test123
            '/^fake\d*$/',     // fake, fake1, fake123
            '/^dummy\d*$/',    // dummy, dummy1
            '/^invalid\d*$/',  // invalid, invalid1
            '/^temp\d*$/',     // temp, temp1
            '/^sample\d*$/',   // sample, sample1
            '/^example\d*$/',  // example, example1
            '/^noreply\d*$/',  // noreply, noreply1
            '/^no-reply\d*$/', // no-reply, no-reply1
            '/^\d+$/',         // Only numbers
            '/^[a-z]\d+$/',    // Single letter followed by numbers (a123, b456)
            '/^.{1,2}$/',      // Too short (1-2 characters)
            '/^.{50,}$/',      // Too long (50+ characters)
        ];

        foreach ($invalidPatterns as $pattern) {
            if (preg_match($pattern, strtolower($localPart))) {
                return true;
            }
        }

        $commonDomains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'];
        if (in_array(strtolower($domain), $commonDomains)) {
            $suspiciousPatterns = [
                '/^[a-z]+\.[a-z]+\d{8,}$/', // firstname.lastname12345678
                '/^[a-z]+\d{10,}$/',        // name1234567890
                '/^[a-z]{20,}$/',           // Very long single word
            ];

            foreach ($suspiciousPatterns as $pattern) {
                if (preg_match($pattern, strtolower($localPart))) {
                    return true;
                }
            }
        }

        return false;
    }

    private function performHeuristicCheck(string $email, string $domain, string $localPart): array
    {
        $score   = 0;
        $reasons = [];

        if (strlen($localPart) < 3) {
            $score -= 30;
            $reasons[] = 'local_part_too_short';
        }

        if (strlen($localPart) > 30) {
            $score -= 20;
            $reasons[] = 'local_part_too_long';
        }

        if (preg_match('/^[a-z]+\d{8,}$/', strtolower($localPart))) {
            $score -= 40;
            $reasons[] = 'random_looking_pattern';
        }

        $commonDomains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'aol.com'];
        if (in_array(strtolower($domain), $commonDomains)) {
            $score += 20;
        } else {
            $score -= 10;
            $reasons[] = 'uncommon_domain';
        }

        if ($this->isInvalidLocalPart($localPart, $domain)) {
            $score -= 60;
            $reasons[] = 'fake_pattern_detected';
        }

        $deliverable = $score > -40; // More lenient threshold

        return [
            'deliverable'       => $deliverable,
            'reason'            => $deliverable ? 'heuristic_passed' : 'heuristic_failed',
            'details'           => $deliverable
            ? 'Email passed heuristic analysis'
            : 'Email failed heuristic analysis: ' . implode(', ', $reasons),
            'heuristic_score'   => $score,
            'heuristic_reasons' => $reasons,
        ];
    }

    private function checkDomainReputation(string $domain): array
    {
        try {
            $riskyTlds = ['tk', 'ml', 'ga', 'cf', 'gq'];
            $tld       = substr(strrchr($domain, "."), 1);

            if (in_array($tld, $riskyTlds)) {
                return ['safe' => false, 'reason' => 'risky_tld', 'score' => 30];
            }

            return ['safe' => true, 'reason' => 'passed_basic_checks', 'score' => 85];

        } catch (\Exception $e) {
            Log::warning('Domain reputation check failed', [
                'domain' => $domain,
                'error'  => $e->getMessage(),
            ]);

            return ['safe' => true, 'reason' => 'check_failed', 'score' => 50];
        }
    }

    private function isDisposableEmail(string $domain): bool
    {
        return in_array($domain, $this->disposableDomains) ||
        $this->matchesDisposablePattern($domain);
    }

    private function matchesDisposablePattern(string $domain): bool
    {
        $patterns = [
            '/^temp.*\.com$/',
            '/^.*temp.*\.com$/',
            '/^10minute.*/',
            '/^.*guerrilla.*/',
            '/^.*disposable.*/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $domain)) {
                return true;
            }
        }

        return false;
    }

    private function isRiskyDomain(string $domain): bool
    {
        return in_array($domain, $this->riskyDomains);
    }

    private function isRoleBasedEmail(string $localPart): bool
    {
        return in_array($localPart, $this->roleBasedPrefixes);
    }

    private function createResult(bool $isValid, string $reason, string $details, array $additionalData = []): array
    {
        return [
            'is_valid'        => $isValid,
            'reason'          => $reason,
            'details'         => $details,
            'timestamp'       => now()->toISOString(),
            'additional_data' => $additionalData,
        ];
    }

    private function loadDisposableDomains(): void
    {
        $cachedDomains = Cache::get('disposable_email_domains', []);

        $this->disposableDomains = array_merge([
            '10minutemail.com',
            'guerrillamail.com',
            'mailinator.com',
            'tempmail.org',
            'throwaway.email',
            'temp-mail.org',
            'getnada.com',
            'maildrop.cc',
            'mailnesia.com',
            'yopmail.com',
            'sharklasers.com',
            'grr.la',
            'guerrillamailblock.com',
            'pokemail.net',
            'spam4.me',
            'bccto.me',
            'chacuo.net',
            'dispostable.com',
            'tempail.com',
            'tempmailaddress.com',
        ], $cachedDomains);
    }

    private function loadRiskyDomains(): void
    {
        $this->riskyDomains = [
            'example.com',
            'test.com',
            'spam.com',
            'faiz.com',
            'invalid.com',
            'fake.com',
            'dummy.com',
            'localhost',
            'local',
        ];
    }

    private function loadRoleBasedPrefixes(): void
    {
        $this->roleBasedPrefixes = [
            'admin',
            'administrator',
            'info',
            'support',
            'help',
            'sales',
            'marketing',
            'noreply',
            'no-reply',
            'webmaster',
            'postmaster',
            'root',
            'mail',
            'email',
            'test',
            'demo',
        ];
    }

    /**
     * Update disposable domains list from online source
     */
    public function updateDisposableDomainsFromAPI(): bool
    {
        try {
            $response = Http::timeout(10)->get('https://raw.githubusercontent.com/disposable/disposable-email-domains/master/domains.txt');

            if ($response->successful()) {
                $domains = array_filter(explode("\n", $response->body()));
                $domains = array_map('trim', $domains);

                Cache::put('disposable_email_domains', $domains, now()->addDays(7));

                Log::info('Updated disposable email domains list', ['count' => count($domains)]);
                return true;
            }
        } catch (\Exception $e) {
            Log::warning('Failed to update disposable domains list', ['error' => $e->getMessage()]);
        }

        return false;
    }
}
