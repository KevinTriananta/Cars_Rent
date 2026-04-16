<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Mail\BookingApproved;
use App\Mail\BookingRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['car', 'user'])->latest()->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Handle bulk operations for bookings.
     */
    public function bulk(Request $request)
    {
        $request->validate([
            'booking_ids' => 'required|array',
            'booking_ids.*' => 'exists:bookings,id',
            'action' => 'required|in:approve,reject,pending'
        ]);

        $bookingIds = $request->booking_ids;
        $action = $request->action;

        switch ($action) {
            case 'approve':
                Booking::whereIn('id', $bookingIds)->where('status', '!=', 'approved')->update(['status' => 'approved']);
                // Update car status to rented
                $bookings = Booking::whereIn('id', $bookingIds)->with('car')->get();
                foreach ($bookings as $booking) {
                    if ($booking->car) {
                        $booking->car->update(['status' => 'rented']);
                    }
                }
                $message = 'Booking berhasil disetujui.';
                break;
            case 'reject':
                Booking::whereIn('id', $bookingIds)->where('status', '!=', 'rejected')->update(['status' => 'rejected']);
                // Update car status back to available if it was approved
                $bookings = Booking::whereIn('id', $bookingIds)->with('car')->get();
                foreach ($bookings as $booking) {
                    if ($booking->car && $booking->status === 'approved') {
                        $booking->car->update(['status' => 'available']);
                    }
                }
                $message = 'Booking berhasil ditolak.';
                break;
            case 'pending':
                Booking::whereIn('id', $bookingIds)->where('status', '!=', 'pending')->update(['status' => 'pending']);
                // Update car status back to available if it was approved
                $bookings = Booking::whereIn('id', $bookingIds)->with('car')->get();
                foreach ($bookings as $booking) {
                    if ($booking->car && $booking->status === 'approved') {
                        $booking->car->update(['status' => 'available']);
                    }
                }
                $message = 'Status booking diubah menjadi pending.';
                break;
        }

        return back()->with('success', $message);
    }

    public function approve(Booking $booking)
    {
        if ($booking->status !== 'approved') {
            $booking->update(['status' => 'approved']);

            if ($booking->car && $booking->car->status !== 'rented') {
                $booking->car->update(['status' => 'rented']);
            }

            // Send email notification
            Mail::to($booking->user->email)->send(new BookingApproved($booking));
        }

        return back()->with('success', 'Booking berhasil disetujui.');
    }

    public function reject(Booking $booking)
    {
        if ($booking->status !== 'rejected') {
            if ($booking->status === 'approved' && $booking->car) {
                $booking->car->update(['status' => 'available']);
            }

            $booking->update(['status' => 'rejected']);

            // Send email notification
            Mail::to($booking->user->email)->send(new BookingRejected($booking));
        }

        return back()->with('success', 'Booking berhasil ditolak.');
    }

    public function pending(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            if ($booking->status === 'approved' && $booking->car) {
                $booking->car->update(['status' => 'available']);
            }

            $booking->update(['status' => 'pending']);
        }

        return back()->with('success', 'Status booking diubah menjadi pending.');
    }
}
