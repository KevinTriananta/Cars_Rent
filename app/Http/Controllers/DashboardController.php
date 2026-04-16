<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil ID user yang sedang login
        $userId = auth()->id();

        // 2. Hitung Pesanan Aktif
        // Kriteria: Status 'approved' dan tanggal selesai masih di masa depan atau hari ini
        $pesananAktif = Booking::where('user_id', $userId)
            ->where('status', 'approved')
            ->where('end_date', '>=', Carbon::today())
            ->count();

        // 3. Hitung Total Pengeluaran
        // Menjumlahkan kolom 'total_price' dari semua booking user yang sudah 'approved'
        $totalPengeluaran = Booking::where('user_id', $userId)
            ->where('status', 'approved')
            ->sum('total_price');

        $nextReturnBooking = Booking::where('user_id', $userId)
            ->where('status', 'approved')
            ->where('end_date', '>=', Carbon::today())
            ->orderBy('end_date')
            ->first();

        $tanggalPengembalian = $nextReturnBooking
            ? Carbon::parse($nextReturnBooking->end_date)->format('d M Y')
            : null;

        // 5. Ambil Aktivitas Terbaru
        // Mengambil 5 riwayat booking terakhir milik user, termasuk relasi data mobilnya
        $aktivitasTerbaru = Booking::with('car')
            ->where('user_id', $userId)
            ->latest() // Urutkan dari yang paling baru dibuat
            ->take(5)  // Ambil maksimal 5 data
            ->get();

        // 6. Kirim semua variabel ke view 'dashboard'
        return view('dashboard', compact(
            'pesananAktif', 
            'totalPengeluaran', 
            'tanggalPengembalian', 
            'aktivitasTerbaru'
        ));
    }
}