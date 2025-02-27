<?php

namespace App\Livewire\Auth;

use App\Models\Cart;
use App\Models\User;
use Livewire\Component;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LoginPage extends Component
{

    use LivewireAlert;

    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email|max:255|exists:users,email',
        'password' => 'required|min:8|max:255',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function login()
    {
        $this->validate();

        // Cek apakah login sebagai user
        if (Auth::guard('web')->attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();

            $this->alert('success', 'Login successful! Redirecting...', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => true
            ]);

            return redirect()->route('home');
        }

        // Jika gagal login
        $this->alert('error', 'Invalid email or password', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true
        ]);

        $this->reset('password');
    }

    public function goTo() {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        try{
             // Debugging: Periksa konfigurasi Google
            // $config = config('services.google');
            // dd($config); // Pastikan client_id dan client_secret ada dan benar

            // $google_user = Socialite::driver('google')->user();
            $google_user =  Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();
            // dd($google_user->getId(), $user);
            if (!$user) {
                $user = User::where('email', $google_user->getEmail())->first();

                if ($user) {
                    // Jika user dengan email yang sama sudah ada, update google_id
                    $user->update([
                        'google_id' => $google_user->getId(),
                    ]);
                } else {
                    // Jika benar-benar user baru, buat akun baru
                    $user = User::create([
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail(),
                        'google_id' => $google_user->getId(),
                    ]);
                }
            }

            Auth::login($user);

            return redirect()->route('home');
        }catch(\Throwable $th) {
            dd('Something went wrong'. $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
