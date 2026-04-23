<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource for users.
     */
    public function index(Request $request)
    {
        $today = Carbon::today();
        $query = Car::query()->withExists([
            'bookings as has_active_booking_today' => function ($bookingQuery) use ($today) {
                $bookingQuery->whereIn('status', ['pending', 'approved'])
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            }
        ]);

        // Search by name or brand
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        // Filter by status (berdasarkan booking aktif hari ini, bukan status global mobil)
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status === 'available') {
                $query->whereDoesntHave('bookings', function ($bookingQuery) use ($today) {
                    $bookingQuery->whereIn('status', ['pending', 'approved'])
                        ->whereDate('start_date', '<=', $today)
                        ->whereDate('end_date', '>=', $today);
                });
            } elseif ($request->status === 'rented') {
                $query->whereHas('bookings', function ($bookingQuery) use ($today) {
                    $bookingQuery->whereIn('status', ['pending', 'approved'])
                        ->whereDate('start_date', '<=', $today)
                        ->whereDate('end_date', '>=', $today);
                });
            }
        }

        // Filter by price range
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        $sortOptions = [
            'name_asc' => ['column' => 'name', 'direction' => 'asc'],
            'name_desc' => ['column' => 'name', 'direction' => 'desc'],
            'brand_asc' => ['column' => 'brand', 'direction' => 'asc'],
            'brand_desc' => ['column' => 'brand', 'direction' => 'desc'],
            'price_asc' => ['column' => 'price_per_day', 'direction' => 'asc'],
            'price_desc' => ['column' => 'price_per_day', 'direction' => 'desc'],
        ];

        // Sort
        $selectedSort = $request->get('sort_option');

        if (isset($sortOptions[$selectedSort])) {
            $sortBy = $sortOptions[$selectedSort]['column'];
            $sortDirection = $sortOptions[$selectedSort]['direction'];
        } else {
            $sortBy = $request->get('sort', 'name');
            $sortDirection = $request->get('direction', 'asc');
        }

        if (! in_array($sortBy, ['name', 'brand', 'price_per_day'], true)) {
            $sortBy = 'name';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'asc';
        }

        $query->orderBy($sortBy, $sortDirection);

        $cars = $query->paginate(12);

        return view('cars.index', compact('cars'));
    }

    /**
     * Display the specified car.
     */
    public function show(Car $car)
    {
        $today = Carbon::today();
        $isBookedToday = $car->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->exists();

        return view('cars.show', compact('car', 'isBookedToday'));
    }

    /**
     * Show calendar availability for a car.
     */
    public function calendar(Car $car)
    {
        // Tanggal yang bentrok dianggap tidak tersedia (pending + approved).
        $bookings = $car->bookings()
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        return view('cars.calendar', compact('car', 'bookings'));
    }
}
