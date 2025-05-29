<?php
namespace App\Console\Commands;

use App\Services\EmailValidationService;
use Illuminate\Console\Command;

class UpdateEmailDomainsCommand extends Command
{
    protected $signature   = 'email:update-domains';
    protected $description = 'Update disposable email domains list from external source';

    public function handle(EmailValidationService $emailValidationService): int
    {
        $this->info('Updating disposable email domains list...');

        $success = $emailValidationService->updateDisposableDomainsFromAPI();

        if ($success) {
            $this->info('✅ Disposable email domains list updated successfully!');
            return self::SUCCESS;
        } else {
            $this->error('❌ Failed to update disposable email domains list.');
            return self::FAILURE;
        }
    }
}
