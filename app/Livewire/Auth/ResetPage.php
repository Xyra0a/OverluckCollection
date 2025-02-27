<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ResetPage extends Component
{

    use LivewireAlert;

    public $token;
    #[Url]
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function resetPassword()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|min:8|max:255|confirmed',
        ]);

        $status = Password::reset(
            [
                'email' => $this->email,
                'token' => $this->token,
                'password' => $this->password,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $this->alert('success', 'Password reset successfully! Redirecting to login...', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => true
            ]);

            return redirect()->route('login');
        } else {
            $this->alert('error', trans($status), [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => true
            ]);

            session()->flash('error', trans($status));
        }
    }
    public function render()
    {
        return view('livewire.auth.reset-page');
    }
}
