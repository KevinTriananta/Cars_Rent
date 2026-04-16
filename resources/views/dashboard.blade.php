@extends('layouts.custom')

@section('content')
<div class="grid grid-cols-1 gap-6">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-500 mt-2">Hari ini adalah hari yang tepat untuk merencanakan perjalanan Anda.</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:bg-blue-700 transition">Mulai Sewa Sekarang</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-600 p-6 rounded-3xl text-white shadow-xl shadow-blue-100">
            <p class="text-blue-100">Pesanan Aktif</p>
            <h3 class="text-4xl font-bold mt-2">{{ $pesananAktif }}</h3>
            <p class="mt-4 text-sm opacity-80">Jumlah booking aktif yang masih berjalan.</p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <p class="text-gray-400">Total Pengeluaran</p>
            <h3 class="text-4xl font-bold mt-2 text-gray-800">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            <a href="{{ route('bookings.index') }}" class="mt-4 inline-flex text-sm text-green-500 font-medium hover:text-green-600">Lihat riwayat transaksi →</a>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <p class="text-gray-400">Tanggal Pengembalian Mobil</p>
            <h3 class="text-4xl font-bold mt-2 text-gray-800">{{ $tanggalPengembalian ?? 'Belum ada pengembalian aktif' }}</h3>
            <a href="{{ route('bookings.index') }}" class="mt-4 inline-flex text-sm text-blue-500 font-medium hover:text-blue-600">Lihat detail booking →</a>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="font-bold text-gray-800 uppercase tracking-wider text-sm">Aktivitas Terbaru</h3>
                <p class="text-sm text-gray-500 mt-1">Riwayat booking terakhir milik Anda.</p>
            </div>
            <span class="text-xs bg-gray-100 px-3 py-1 rounded-full text-gray-500">Update: {{ date('d M Y') }}</span>
        </div>

        @if($aktivitasTerbaru->isEmpty())
            <div class="p-10 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" class="w-20 mx-auto opacity-20 mb-4">
                <p class="text-gray-400">Belum ada aktivitas penyewaan terbaru.</p>
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach($aktivitasTerbaru as $booking)
                    <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Booking #{{ $booking->id }} · {{ ucfirst($booking->status) }}</p>
                            <h4 class="text-lg font-semibold text-gray-800 mt-2">{{ $booking->car->name }} • {{ $booking->car->brand }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ \Illuminate\Support\Carbon::parse($booking->start_date)->format('d M Y') }} — {{ \Illuminate\Support\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Total Pembayaran</p>
                            <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection