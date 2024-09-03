<?php

use App\Livewire\ManagePublish;
use App\Livewire\ManageTransfers;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('dev-login', function () {
    abort_unless(app()->environment('local'), 403);

    auth()->loginUsingId(\App\Models\User::first());

    return redirect()->to('beranda');
});

Route::middleware(['auth'])->group(function () {
    Volt::route('beranda', 'beranda')->name('beranda');
    Volt::route('karyawan-personalia', 'karyawan-personalia')->name('karyawan-personalia');
    Volt::route('karyawan-payroll-insentif', 'karyawan-payroll-insentif')->name('payroll-insentif');
    Volt::route('karyawan-payroll-kehadiran', 'payroll.kehadiran')->name('payroll-insentif');

    
    Route::get('/bukti-potong-upload', ManageTransfers::class)->name('bupot-upload');
    Route::get('/bukti-potong-publish', ManagePublish::class)->name('bupot-publish');
});

require __DIR__ . '/auth.php';
