@extends('layouts.custom')

@section('content')
@php
    $sortOption = request('sort_option');

    if (!$sortOption) {
        $currentSort = request('sort', 'name');
        $currentDirection = request('direction', 'asc');
        $sortOption = match ($currentSort . '_' . $currentDirection) {
            'price_per_day_asc' => 'price_asc',
            'price_per_day_desc' => 'price_desc',
            'brand_asc' => 'brand_asc',
            'brand_desc' => 'brand_desc',
            'name_desc' => 'name_desc',
            default => 'name_asc',
        };
    }

    $hasAdvancedFilters = filled(request('min_price')) || filled(request('max_price'));
    $activeFilterCount = collect([
        request('search'),
        request('status'),
        request('min_price'),
        request('max_price'),
    ])->filter(fn ($value) => filled($value))->count();

    $sortLabels = [
        'name_asc' => 'Nama A-Z',
        'name_desc' => 'Nama Z-A',
        'brand_asc' => 'Merek A-Z',
        'brand_desc' => 'Merek Z-A',
        'price_asc' => 'Harga Termurah',
        'price_desc' => 'Harga Tertinggi',
    ];
@endphp
<div class="space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">Mobil Tersedia</h1>
        <span class="text-sm text-gray-500">Total: <span class="font-semibold">{{ $cars->total() }}</span> mobil</span>
    </div>

    <!-- Search and Filter Form -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <form method="GET" action="{{ route('cars.index') }}" class="space-y-5">
            <div class="space-y-3">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Mobil</label>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Nama atau merk mobil"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                    >
                    <button type="submit" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Cari
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="w-full">
                    <label for="status" class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia Hari Ini</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Sedang Disewa</option>
                    </select>
                </div>
                <div class="w-full">
                    <label for="sort_option" class="mb-1 block text-sm font-medium text-gray-700">Urutkan</label>
                    <select name="sort_option" id="sort_option" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="name_asc" {{ $sortOption === 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="name_desc" {{ $sortOption === 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                        <option value="brand_asc" {{ $sortOption === 'brand_asc' ? 'selected' : '' }}>Merek A-Z</option>
                        <option value="brand_desc" {{ $sortOption === 'brand_desc' ? 'selected' : '' }}>Merek Z-A</option>
                        <option value="price_asc" {{ $sortOption === 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="price_desc" {{ $sortOption === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </div>
            </div>

            <details class="group rounded-2xl border border-gray-200 bg-gray-50/80 p-4" {{ $hasAdvancedFilters ? 'open' : '' }}>
                <summary class="flex cursor-pointer list-none items-center justify-between gap-3 text-sm font-semibold text-gray-800">
                    <span>Filter lanjutan</span>
                    <span class="flex items-center gap-2 text-xs font-medium text-gray-500">
                        @if($activeFilterCount > 0)
                            <span class="rounded-full bg-blue-100 px-2.5 py-1 text-blue-700">{{ $activeFilterCount }} aktif</span>
                        @endif
                        <span class="transition group-open:rotate-180">⌄</span>
                    </span>
                </summary>

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="min_price" class="mb-1 block text-sm font-medium text-gray-700">Harga Min</label>
                        <input
                            type="number"
                            name="min_price"
                            id="min_price"
                            value="{{ request('min_price') }}"
                            placeholder="Contoh: 300000"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >
                    </div>
                    <div>
                        <label for="max_price" class="mb-1 block text-sm font-medium text-gray-700">Harga Max</label>
                        <input
                            type="number"
                            name="max_price"
                            id="max_price"
                            value="{{ request('max_price') }}"
                            placeholder="Contoh: 600000"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >
                    </div>
                </div>
            </details>

            @if($activeFilterCount > 0)
                <div class="flex flex-wrap gap-2">
                    @if(request('search'))
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">Cari: {{ request('search') }}</span>
                    @endif
                    @if(request('status'))
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">Status: {{ request('status') === 'available' ? 'Tersedia' : 'Disewa' }}</span>
                    @endif
                    @if(request('min_price') || request('max_price'))
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                            Harga: {{ request('min_price') ? 'Rp ' . number_format((int) request('min_price'), 0, ',', '.') : 'min bebas' }} - {{ request('max_price') ? 'Rp ' . number_format((int) request('max_price'), 0, ',', '.') : 'max bebas' }}
                        </span>
                    @endif
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">Urut: {{ $sortLabels[$sortOption] ?? 'Nama A-Z' }}</span>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-2 sm:flex sm:justify-end">
                <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 sm:w-auto">
                    Terapkan
                </button>
                <a href="{{ route('cars.index') }}" class="w-full rounded-xl bg-gray-500 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-gray-600 sm:w-auto">
                    Reset
                </a>
            </div>
        </form>
    </div>

    @if($cars->count() > 0)
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($cars as $car)
                <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-lg transition">
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="w-full h-40 object-cover" />
                    @else
                        <div class="h-40 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm11 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-800">{{ $car->name }}</h3>
                        <p class="text-sm text-gray-500 mb-3">{{ $car->brand }}</p>
                        
                        <p class="text-blue-600 font-bold text-lg mb-3">Rp {{ number_format($car->price_per_day, 0, ',', '.') }} / Hari</p>
                        
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                ✓ Tersedia
                            </span>
                            @if($car->has_active_booking_today)
                                <p class="mt-2 text-xs text-orange-600">Sedang disewa hari ini, pilih tanggal lain di kalender.</p>
                            @else
                                <p class="mt-2 text-xs text-gray-500">Tersedia untuk hari ini.</p>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            <a href="{{ route('cars.show', $car) }}" class="flex-1 text-center bg-gray-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
                                Lihat Detail
                            </a>
                            <a href="{{ route('bookings.create', ['car' => $car->id]) }}" class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $cars->appends(request()->query())->links() }}
        </div>
    @else
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center">
            <p class="text-gray-500">Belum ada mobil yang tersedia</p>
        </div>
    @endif
</div>
@endsection
