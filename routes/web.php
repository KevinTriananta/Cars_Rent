<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CarsController as AdminCarsController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Models\Car;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredCars = Car::orderBy('price_per_day', 'asc')->limit(4)->get();
    return view('welcome', compact('featuredCars'));
});

// LOGIKA REDIRECT UTAMA SETELAH LOGIN
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Cek jika role adalah admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Jika bukan admin (user biasa), panggil controller dashboard user
        return app(DashboardController::class)->index();
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cars (User - View Only)
    Route::get('/cars', [CarsController::class, 'index'])->name('cars.index');
    Route::get('/cars/{car}', [CarsController::class, 'show'])->name('cars.show');
    Route::get('/cars/{car}/calendar', [CarsController::class, 'calendar'])->name('cars.calendar');

    // Booking (User)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/new', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/payment', [BookingController::class, 'payment'])->name('bookings.payment');

    // Admin Routes (Dibatasi dengan Middleware Role)
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Admin Cars Management
        Route::get('/cars', [AdminCarsController::class, 'index'])->name('admin.cars.index');
        Route::post('/cars/bulk', [AdminCarsController::class, 'bulk'])->name('admin.cars.bulk');
        Route::get('/cars/create', [AdminCarsController::class, 'create'])->name('admin.cars.create');
        Route::post('/cars', [AdminCarsController::class, 'store'])->name('admin.cars.store');
        Route::get('/cars/{car}/edit', [AdminCarsController::class, 'edit'])->name('admin.cars.edit');
        Route::put('/cars/{car}', [AdminCarsController::class, 'update'])->name('admin.cars.update');
        Route::delete('/cars/{car}', [AdminCarsController::class, 'destroy'])->name('admin.cars.destroy');

        // Admin Booking Management
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
        Route::post('/bookings/bulk', [AdminBookingController::class, 'bulk'])->name('admin.bookings.bulk');
        Route::patch('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('admin.bookings.approve');
        Route::patch('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('admin.bookings.reject');
        Route::patch('/bookings/{booking}/pending', [AdminBookingController::class, 'pending'])->name('admin.bookings.pending');
    });
});

require __DIR__.'/auth.php';