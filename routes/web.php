<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/api/available-slots', [BookingController::class, 'getAvailableSlots'])->name('api.available-slots');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::get('/success', [BookingController::class, 'success'])->name('booking.success');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('admin/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// Admin Protected Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings/create', [AdminController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [AdminController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/edit', [AdminController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [AdminController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [AdminController::class, 'destroy'])->name('bookings.destroy');
    Route::patch('/bookings/{booking}/status', [AdminController::class, 'updateStatus'])->name('bookings.update-status');
});
