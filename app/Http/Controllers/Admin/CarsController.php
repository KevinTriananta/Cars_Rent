<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    public function index()
    {
        $cars = Car::latest()->get();
        return view('admin.cars.index', compact('cars'));
    }
    /**
     * Handle bulk operations for cars.
     */
    public function bulk(Request $request)
    {
        $request->validate([
            'car_ids' => 'required|array',
            'car_ids.*' => 'exists:cars,id',
            'action' => 'required|in:delete,available,rented'
        ]);

        $carIds = $request->car_ids;
        $action = $request->action;

        switch ($action) {
            case 'delete':
                Car::whereIn('id', $carIds)->delete();
                $message = 'Mobil berhasil dihapus.';
                break;
            case 'available':
                Car::whereIn('id', $carIds)->update(['status' => 'available']);
                $message = 'Status mobil berhasil diubah menjadi tersedia.';
                break;
            case 'rented':
                Car::whereIn('id', $carIds)->update(['status' => 'rented']);
                $message = 'Status mobil berhasil diubah menjadi disewa.';
                break;
        }

        return back()->with('success', $message);
    }
    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented',
        ]);

        Car::create($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented',
        ]);

        $car->update($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil dihapus.');
    }
}
