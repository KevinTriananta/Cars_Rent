@extends('layouts.custom')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-64 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
            <svg class="w-24 h-24 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm11 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
            </svg>
        </div>
        
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $car->name }}</h1>
                    <p class="text-lg text-gray-600">{{ $car->brand }}</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">per hari</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 mb-6">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $car->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                    {{ $car->status === 'available' ? '✓ Tersedia' : 'x Sedang Disewa' }}
                </span>
            </div>
            
            @if($car->status === 'available')
                <div class="flex gap-3">
                    <a href="{{ route('bookings.create', ['car' => $car->id]) }}" class="flex-1 text-center bg-blue-600 text-white py-3 rounded-full text-lg font-semibold hover:bg-blue-700 transition">
                        Pesan Sekarang
                    </a>
                    <a href="{{ route('cars.calendar', $car) }}" class="flex-1 text-center bg-green-600 text-white py-3 rounded-full text-lg font-semibold hover:bg-green-700 transition">
                        Lihat Kalender
                    </a>
                </div>
            @else
                <button disabled class="block w-full text-center bg-gray-300 text-gray-500 py-3 rounded-full text-lg font-semibold cursor-not-allowed">
                    Tidak Tersedia
                </button>
            @endif
        </div>
    </div>

    <!-- Specifications -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Spesifikasi Mobil</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Merk:</span>
                    <span class="font-semibold">{{ $car->brand }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama:</span>
                    <span class="font-semibold">{{ $car->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Harga per Hari:</span>
                    <span class="font-semibold text-blue-600">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-semibold {{ $car->status === 'available' ? 'text-green-600' : 'text-orange-600' }}">
                        {{ ucfirst($car->status) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Kategori:</span>
                    <span class="font-semibold">Mobil</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('cars.index') }}" class="inline-flex items-center justify-center bg-gray-100 text-gray-700 px-6 py-3 rounded-full text-sm font-semibold hover:bg-gray-200 transition">
            ← Kembali ke Daftar Mobil
        </a>
    </div>
</div>
@endsection