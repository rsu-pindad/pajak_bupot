<?php

use App\Http\Controllers\KehadiranController;
use App\Livewire\ManagePublish;
use App\Livewire\ManageTransfers;
use App\Models\Insentif;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\InsentifController;

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

Volt::route('/', 'pages.auth.login')
    ->middleware(['guest']);



Route::get('dev-login', function () {
    abort_unless(app()->environment('local'), 403);

    auth()->loginUsingId(\App\Models\User::first());

    return redirect()->to('beranda');
});

Route::middleware(['auth'])->group(function () {
    Volt::route('profile', 'profile')->name('profile');

    Volt::route('beranda', 'beranda')->name('beranda');
    Volt::route('karyawan-personalia', 'karyawan.personalia')->name('karyawan-personalia');
    // Volt::route('karyawan-payroll-insentif', 'karyawan-payroll-insentif')->name('payroll-insentif');
    Volt::route('karyawan-payroll-insentif', 'payroll.insentif')->name('payroll-insentif');
    Volt::route('karyawan-payroll-kehadiran', 'payroll.kehadiran')->name('payroll-kehadiran');

    Route::get('/bukti-potong-upload', ManageTransfers::class)->name('bupot-upload');
    Route::get('/bukti-potong-publish', ManagePublish::class)->name('bupot-publish');

    Volt::route('berkas-insentif', 'employee.insentif')->name('employee-insentif');
    Volt::route('berkas-kehadiran', 'employee.kehadiran')->name('employee-kehadiran');
});

Route::middleware('throttle:3,1')->group(function () {
    Route::get('/berkas-kehadiran-karyawan/{user}/{bulan}/{tahun}', [KehadiranController::class, '__invoke'])->name('berkas-kehadiran-karyawan');
    Route::get('/slip-kehadiran/{user}', [KehadiranController::class, 'view'])->name('slip-kehadiran');
    
    Route::get('/berkas-insentif-karyawan/{user}/{bulan}/{tahun}', [InsentifController::class, '__invoke'])->name('berkas-insentif-karyawan');
    Route::get('/slip-insentif/{user}', [InsentifController::class, 'view'])->name('slip-insentif');
});

require __DIR__ . '/auth.php';
