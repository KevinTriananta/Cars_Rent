@extends('layouts.custom')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Booking Berhasil!</h1>
            <p class="text-gray-600 mt-2">Pesanan Anda telah dibuat. Silakan lakukan pembayaran untuk menyelesaikan proses.</p>
        </div>

        <!-- Booking Details -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">ID Booking:</span>
                    <span class="font-semibold">#{{ $booking->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Mobil:</span>
                    <span class="font-semibold">{{ $booking->car->name }} ({{ $booking->car->brand }})</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tanggal Sewa:</span>
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">{{ ucfirst($booking->status) }}</span>
                </div>
                <hr class="my-3">
                <div class="flex justify-between text-lg">
                    <span class="font-semibold text-gray-900">Total Pembayaran:</span>
                    <span class="font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6 border-radius-3xl">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">Instruksi Pembayaran</h3>
            <ol class="list-decimal list-inside space-y-2 text-blue-800">
                <li>Transfer pembayaran ke rekening: <strong>DANA 085710840941 a/n Kevin Triananta</strong></li>
                <li>Klik tombol "Kirim Konfirmasi via WhatsApp" di bawah</li>
                <li>Kirim bukti transfer melalui WhatsApp</li>
                <li>Admin akan mengkonfirmasi dan mengubah status booking Anda</li>
            </ol>
        </div>

        <!-- WhatsApp Button -->
        <div class="text-center">
            <a href="{{ $whatsappUrl }}" target="_blank" class="inline-flex items-center justify-center bg-green-600 text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-green-700 transition">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
                Kirim Konfirmasi via WhatsApp
            </a>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800">Kembali ke Daftar Booking</a>
        </div>
    </div>
</div>
@endsection