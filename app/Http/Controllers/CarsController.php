<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource for users.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        // Search by name or brand
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by price range
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        // Sort
        $sortBy = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $cars = $query->paginate(12);

        return view('cars.index', compact('cars'));
    }

    /**
     * Display the specified car.
     */
    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    /**
     * Show calendar availability for a car.
     */
    public function calendar(Car $car)
    {
        // Get all bookings for this car that are not cancelled/rejected
        $bookings = $car->bookings()
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->get();

        return view('cars.calendar', compact('car', 'bookings'));
    }
}
