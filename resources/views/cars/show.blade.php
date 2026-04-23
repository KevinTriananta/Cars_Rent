@extends('layouts.custom')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        @if($car->image)
            <button
                type="button"
                id="openImageFullscreen"
                class="group relative block w-full focus:outline-none focus:ring-4 focus:ring-blue-200"
                aria-label="Lihat gambar mobil fullscreen"
            >
                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-56 sm:h-64 object-cover" />
                <span class="absolute right-3 top-3 rounded-lg bg-black/55 px-3 py-1 text-xs font-semibold text-white opacity-90 group-hover:bg-black/70">
                    Klik untuk fullscreen
                </span>
            </button>
        @else
            <div class="h-64 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                <svg class="w-24 h-24 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm11 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                </svg>
            </div>
        @endif
        
        <div class="p-5 sm:p-6">
            <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $car->name }}</h1>
                    <p class="text-lg text-gray-600">{{ $car->brand }}</p>
                </div>
                <div class="sm:text-right">
                    <p class="text-2xl sm:text-3xl font-bold text-blue-600">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">per hari</p>
                </div>
            </div>
            
            <div class="mb-6 flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:gap-4">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                    ✓ Tersedia
                </span>
                @if($isBookedToday)
                    <span class="text-sm text-orange-600">Sedang ada penyewaan pada hari ini</span>
                @endif
            </div>

            <p class="text-sm text-gray-600 mb-4">
                Cek kalender untuk melihat ketersediaan mobil pada tanggal yang anda inginkan.
            </p>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <a href="{{ route('bookings.create', ['car' => $car->id]) }}" class="flex-1 text-center bg-blue-600 text-white py-3 rounded-full text-lg font-semibold hover:bg-blue-700 transition">
                    Pesan Sekarang
                </a>
                <a href="{{ route('cars.calendar', $car) }}" class="flex-1 text-center bg-green-600 text-white py-3 rounded-full text-lg font-semibold hover:bg-green-700 transition">
                    Lihat Kalender
                </a>
            </div>
        </div>
    </div>

    <!-- Specifications -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">Spesifikasi Mobil</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <span class="text-gray-600">Merk:</span>
                    <span class="font-semibold">{{ $car->brand }}</span>
                </div>
                <div class="flex items-start justify-between gap-4">
                    <span class="text-gray-600">Nama:</span>
                    <span class="font-semibold">{{ $car->name }}</span>
                </div>
                <div class="flex items-start justify-between gap-4">
                    <span class="text-gray-600">Harga per Hari:</span>
                    <span class="font-semibold text-blue-600">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-semibold text-green-600">
                        Tersedia (cek kalender)
                    </span>
                </div>
                <div class="flex items-start justify-between gap-4">
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

@if($car->image)
    <div
        id="imageFullscreenModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 p-4"
        role="dialog"
        aria-modal="true"
        aria-label="Preview gambar mobil fullscreen"
    >
        <button
            type="button"
            id="closeImageFullscreen"
            class="absolute right-4 top-4 rounded-full bg-white/15 px-3 py-2 text-sm font-semibold text-white hover:bg-white/30"
            aria-label="Tutup fullscreen"
        >
            ✕ Tutup
        </button>
        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="max-h-[92vh] max-w-[96vw] rounded-xl object-contain shadow-2xl" />
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const openBtn = document.getElementById('openImageFullscreen');
        const closeBtn = document.getElementById('closeImageFullscreen');
        const modal = document.getElementById('imageFullscreenModal');

        if (!openBtn || !closeBtn || !modal) return;

        const openModal = () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        };

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        };

        openBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', function (event) {
            if (event.target === modal) closeModal();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
    </script>
@endif
@endsection
