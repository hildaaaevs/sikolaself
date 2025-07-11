<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register')]
class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    // register user
    public function save(){
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|max:255'
        ]);
        
        // save to database
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        // set success message
        session()->flash('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');

        // redirect to login page
        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
