<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Forgot Password')]
class ForgotPage extends Component
{
    use LivewireAlert;
    public $email;

    public function forgot()
{
    $this->validate([
        'email' => ['required', 'email', 'max:255', 'exists:users,email'],
    ]);

    $status = Password::sendResetLink([
        'email' => $this->email
    ]);

    if ($status === Password::RESET_LINK_SENT) {
        $this->alert('success', trans($status), [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true
        ]);
    } else {
        $this->alert('error', trans($status), [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true
        ]);
    }
}
    public function render()
    {
        return view('livewire.auth.forgot-page');
    }
}
