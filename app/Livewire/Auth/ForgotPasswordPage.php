<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forgot Password')]
class ForgotPasswordPage extends Component
{
    public $email;

    public function save(){
        $this->validate([
            'email' => 'required|email|exists:users,email|max:255'
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status == Password::RESET_LINK_SENT){
            session()->flash('success', 'Password reset link terkirim');
            $this->email = '';
        } else {
            session()->flash('error', 'Gagal mengirim link reset password');
        }
    }
    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }
}
