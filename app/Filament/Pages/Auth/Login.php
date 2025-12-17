<?php

declare(strict_types=1);

namespace App\Filament\Pages\Auth;

final class Login extends \Filament\Auth\Pages\Login
{
    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'email' => 'admin@filamentphp.com',
            'password' => 'demo.Filament@2021!',
            'remember' => true,
        ]);
    }
}
