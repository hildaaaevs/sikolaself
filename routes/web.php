<?php

use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\BookingPage;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\DetailPaketFotoPage;
use App\Livewire\Histori;
use App\Livewire\HomePage;
use App\Livewire\PaketFotoPage;
use App\Livewire\SuccesPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/paketfoto', PaketFotoPage::class);
Route::get('/paketfoto/{nama_paket_foto}', DetailPaketFotoPage::class);


Route::get('/login', LoginPage::class);
Route::get('/register', RegisterPage::class);
Route::get('/forgot', ForgotPasswordPage::class);
Route::get('/reset', ResetPasswordPage::class);

Route::middleware('guest')->group(function(){
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/forgot', ForgotPasswordPage::class)->name('password.request');
    Route::get('/reset/{token}', ResetPasswordPage::class)->name('password.reset');
    Route::post('/reset-password', [ResetPasswordPage::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function(){
    Route::get('/logout', function(){
        auth()->logout();
        return redirect('/');
    });
    Route::get('/booking', BookingPage::class);
    Route::get('/booking/{id}', BookingPage::class)->name('booking');
    Route::get('/histori', Histori::class);
    Route::get('/cart', CartPage::class);
    Route::get('/success/{id?}', SuccesPage::class)->name('booking.success');
    Route::get('/cancel', CancelPage::class);
});