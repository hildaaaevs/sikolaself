<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class ResetPasswordPage extends Component
{
    public $token;
    #[Url]
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token = null)
    {
        $this->token = $token ?? request()->route('token');
        $this->email = request()->query('email');
    }

    public function save()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function (User $user, string $password) {
                $password = $this->password;
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            session()->flash('success', 'Password berhasil diubah!');
            return redirect('/login');
        } else {
            session()->flash('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
