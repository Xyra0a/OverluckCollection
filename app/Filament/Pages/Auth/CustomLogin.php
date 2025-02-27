<?php

namespace App\Filament\Auth;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use AbanoubNassem\FilamentGRecaptchaField\Forms\Components\GRecaptcha;

class CustomLogin extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                GRecaptcha::make('captcha'),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }
}
