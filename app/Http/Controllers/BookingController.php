<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Mail\BookingCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the current user's bookings.
     */
    public function index()
    {
        $userId = auth()->id();
        $bookings = Booking::with(['car', 'user'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cars = Car::orderBy('name')->get();
        $selectedCarId = $request->integer('car');

        return view('bookings.create', compact('cars', 'selectedCarId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $car = Car::findOrFail($validated['car_id']);

        // Check for overlapping bookings
        $overlappingBooking = Booking::where('car_id', $validated['car_id'])
            ->where(function ($query) use ($validated) {
                $query->where('start_date', '<=', $validated['end_date'])
                      ->where('end_date', '>=', $validated['start_date']);
            })
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($overlappingBooking) {
            return back()->withInput()->withErrors(['car_id' => 'Mobil ini sudah dibooking untuk tanggal yang dipilih.']);
        }

        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $days = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $car->price_per_day * $days;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Send email notification
        Mail::to($booking->user->email)->send(new BookingCreated($booking, $booking->user));

        return redirect()->route('bookings.payment', $booking)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show payment page with WhatsApp link.
     */
    public function payment(Booking $booking)
    {
        
        // Generate WhatsApp message
        $message = "Halo Admin Cars Rent!%0A%0A";
        $message .= "Saya ingin melakukan pembayaran untuk booking:%0A";
        $message .= "ID Booking: {$booking->id}%0A";
        $message .= "Mobil: {$booking->car->name} ({$booking->car->brand})%0A";
        $message .= "Tanggal: {$booking->start_date} - {$booking->end_date}%0A";
        $message .= "Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "%0A%0A";
        $message .= "Mohon konfirmasi pembayaran. Terima kasih!";
        
        $whatsappUrl = "https://wa.me/6285891004010?text=" . $message; // Ganti nomor WhatsApp admin
        
        return view('bookings.payment', compact('booking', 'whatsappUrl'));
    }
}
