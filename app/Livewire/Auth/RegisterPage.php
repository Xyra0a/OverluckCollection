<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Register to continue your shopping - Overluck Collection')]

class RegisterPage extends Component
{

    use LivewireAlert;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    // register function
    public function register()
    {
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:255|confirmed',
        ]);

        // create user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);


        // login user
        // auth()->login($user);
        $this->reset([
            'name',
            'email',
            'password',
            'password_confirmation',
        ]);
        $this->alert('success', 'User registered successfully',[
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true
        ]);

            // Emit event untuk redirect setelah delay
            $this->dispatch('redirectToRegister');
    }
    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
