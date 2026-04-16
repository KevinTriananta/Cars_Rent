<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FormBooking extends Controller
{
    public function store(Request $request)
    {
        $car = Car::find($request->car_id);
    
    // Hitung selisih hari
    $start = \Carbon\Carbon::parse($request->start_date);
    $end = \Carbon\Carbon::parse($request->end_date);
    $durasi = $start->diffInDays($end) + 1;

    $totalPrice = $durasi * $car->price_per_day;

    Booking::create([
        'id' => $request->id,
        'user_id' => auth()->id(),
        'car_id' => $request->car_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'total_price' => $totalPrice,
        'status' => 'pending'
    ]);

    return redirect()->route('my-booking')->with('success', 'Pesanan berhasil dibuat!');
}}