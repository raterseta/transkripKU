<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Spatie\Activitylog\Models\Activity;
use Filament\Forms\Components\Component;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return ''; // Menghilangkan teks "Sign in"
    }
    protected static bool $shouldRegisterNavigation = false;
    protected static bool $shouldRegisterRoute = false;

    // Custom view kamu
    protected static string $view = 'filament.pages.custom-login';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(), 
                // $this->getLoginFormComponent(), 
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }
 
    protected function getLoginFormComponent(): Component 
    {
        return TextInput::make('login')
            ->label('Login')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }
    
   public function authenticate(): ?LoginResponse
{
    try {
        return parent::authenticate();
    } catch (\Exception $e) {
        report($e); // atau log manual
        return app(LoginResponse::class); // redirect ke dashboard meskipun gagal logging
    }
}

    
}

