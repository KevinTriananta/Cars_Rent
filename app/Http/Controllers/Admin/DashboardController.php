<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Booking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $cars = Car::count();
        $bookings = Booking::count();
        $pending = Booking::where('status', 'pending')->count();
        $revenue = Booking::where('status', 'approved')->sum('total_price');
        $rentedCars = Car::where('status', 'rented')->count();
        $maintenance = Car::where('status', 'maintenance')->count();

        $incomeToday = Booking::where('status', 'approved')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');

        $incomeMonth = Booking::where('status', 'approved')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_price');

        $incomeYear = Booking::where('status', 'approved')
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        $carStatuses = [
            'available' => Car::where('status', 'available')->count(),
            'rented' => $rentedCars,
        ];

        $todayBookings = Booking::with(['user', 'car'])
            ->whereDate('start_date', Carbon::today())
            ->orderBy('start_date')
            ->get();

        $recentBookings = Booking::with(['car', 'user'])
            ->latest('updated_at')
            ->take(6)
            ->get();

        $activityFeed = Booking::with(['car', 'user'])
            ->latest('updated_at')
            ->take(6)
            ->get()
            ->map(function ($booking) {
                if ($booking->updated_at->gt($booking->created_at)) {
                    if ($booking->status === 'approved') {
                        return [
                            'message' => "Admin menyetujui booking {$booking->car->name} oleh {$booking->user->name}",
                            'type' => 'success',
                            'time' => $booking->updated_at,
                        ];
                    }

                    if ($booking->status === 'rejected') {
                        return [
                            'message' => "Admin menolak booking {$booking->car->name} oleh {$booking->user->name}",
                            'type' => 'danger',
                            'time' => $booking->updated_at,
                        ];
                    }
                }

                if ($booking->status === 'pending') {
                    return [
                        'message' => "{$booking->user->name} membuat booking {$booking->car->name}",
                        'type' => 'warning',
                        'time' => $booking->created_at,
                    ];
                }

                return [
                    'message' => "{$booking->user->name} booking {$booking->car->name}",
                    'type' => 'info',
                    'time' => $booking->created_at,
                ];
            });

        $reminders = [
            [
                'message' => "{$pending} booking belum diproses",
                'type' => 'warning',
            ],
            [
                'message' => $maintenance > 0 ? "{$maintenance} mobil perlu maintenance" : 'Tidak ada mobil maintenance saat ini',
                'type' => $maintenance > 0 ? 'danger' : 'info',
            ],
            [
                'message' => Booking::where('status', 'approved')->whereDate('end_date', Carbon::today())->count() . ' booking hampir selesai hari ini',
                'type' => 'success',
            ],
        ];

        return view('admin.dashboard', compact(
            'cars', 'bookings', 'pending', 'rentedCars', 'maintenance',
            'incomeToday', 'incomeMonth', 'incomeYear', 'carStatuses',
            'todayBookings', 'recentBookings', 'activityFeed', 'reminders'
        ));
    }
}