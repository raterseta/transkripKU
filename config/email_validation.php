<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Email Validation Settings
    |--------------------------------------------------------------------------
    |
    | Configure various email validation parameters
    |
    */
    'cache_duration'         => env('EMAIL_VALIDATION_CACHE_DURATION', 3600), // 1 hour in seconds

    'dns_validation'         => [
        'enabled' => env('EMAIL_DNS_VALIDATION_ENABLED', true),
        'timeout' => env('EMAIL_DNS_TIMEOUT', 5), // seconds
    ],

    'smtp_check'             => [
        'enabled' => env('EMAIL_SMTP_CHECK_ENABLED', false),
        'timeout' => env('EMAIL_SMTP_TIMEOUT', 5), // seconds
    ],

    'disposable_email_check' => [
        'enabled'     => env('EMAIL_DISPOSABLE_CHECK_ENABLED', true),
        'strict_mode' => env('EMAIL_DISPOSABLE_STRICT_MODE', true),
    ],

    'role_based_check'       => [
        'enabled'         => env('EMAIL_ROLE_BASED_CHECK_ENABLED', true),
        'allowed_domains' => [
            // 'yourcompany.com',
        ],
    ],

    'domain_reputation'      => [
        'enabled' => env('EMAIL_DOMAIN_REPUTATION_CHECK_ENABLED', true),
        'api_key' => env('EMAIL_REPUTATION_API_KEY'),
        'api_url' => env('EMAIL_REPUTATION_API_URL'),
    ],

    'external_services'      => [
        'disposable_domains_url' => 'https://raw.githubusercontent.com/disposable/disposable-email-domains/master/domains.txt',
        'update_frequency'       => 'weekly',
    ],

    'validation_rules'       => [
        'allow_international_domains' => env('EMAIL_ALLOW_INTERNATIONAL_DOMAINS', true),
        'max_length'                  => env('EMAIL_MAX_LENGTH', 254),
        'min_length'                  => env('EMAIL_MIN_LENGTH', 6),
    ],

    'messages'               => [
        'invalid_syntax'        => 'Format alamat email tidak valid. Periksa kembali penulisan email Anda.',
        'disposable_email'      => 'Email sementara/disposable tidak diperbolehkan. Gunakan alamat email aktif Anda.',
        'no_mx_record'          => 'Domain email tidak valid atau tidak dapat menerima email.',
        'risky_domain'          => 'Domain email terdeteksi berisiko. Gunakan email dari penyedia terpercaya.',
        'role_based'            => 'Email berbasis peran (seperti admin@, info@) tidak diperbolehkan. Gunakan email personal Anda.',
        'catch_all_risky'       => 'Domain email ini memiliki konfigurasi yang tidak disarankan.',
        'domain_reputation_low' => 'Domain email memiliki reputasi rendah.',
        'too_long'              => 'Alamat email terlalu panjang.',
        'too_short'             => 'Alamat email terlalu pendek.',
        'heuristic_failed'      => 'Email gagal validasi heuristik. Periksa kembali alamat email Anda.',
    ],
];
