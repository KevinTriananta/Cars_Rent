@extends('layouts.custom')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Pesanan Saya</h1>
        <a href="{{ route('bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">+ Pesan Mobil Baru</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
            <table class="min-w-[680px] w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Mobil</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Tanggal Sewa</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Total Harga</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">
                                {{ $booking->car->name }}
                                <p class="text-xs text-gray-500">{{ $booking->car->brand }}</p>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-sm font-semibold text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $booking->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $booking->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                     ">
                                    @if($booking->status === 'pending')
                                        Menunggu Persetujuan
                                    @elseif($booking->status === 'approved')
                                        Disetujui
                                    @else
                                        Ditolak
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                                Belum ada pesanan. <a href="{{ route('bookings.create') }}" class="text-blue-600 hover:underline">Pesan mobil sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        @else
            <div class="p-8 text-center">
                <p class="text-gray-500 mb-4">Anda belum memiliki pesanan</p>
                <a href="{{ route('bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Pesan Mobil Sekarang</a>
            </div>
        @endif
    </div>
</div>
@endsection
