@extends('layouts.custom')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Mobil Tersedia</h1>
        <span class="text-sm text-gray-500">Total: <span class="font-semibold">{{ $cars->total() }}</span> mobil</span>
    </div>

    <!-- Search and Filter Form -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <form method="GET" action="{{ route('cars.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Mobil</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Nama atau merk mobil" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Sedang Disewa</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Min</label>
                    <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                           placeholder="Rp" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Max</label>
                    <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                           placeholder="Rp" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Sort -->
            <div class="flex items-center gap-4">
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                    <select name="sort" id="sort" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                        <option value="brand" {{ request('sort') == 'brand' ? 'selected' : '' }}>Merk</option>
                        <option value="price_per_day" {{ request('sort') == 'price_per_day' ? 'selected' : '' }}>Harga</option>
                    </select>
                </div>
                <div>
                    <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Arah</label>
                    <select name="direction" id="direction" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>A-Z / Rendah ke Tinggi</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Z-A / Tinggi ke Rendah</option>
                    </select>
                </div>
                <div class="flex gap-2 mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Cari
                    </button>
                    <a href="{{ route('cars.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($cars->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $car->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $car->status === 'available' ? '✓ Tersedia' : 'x Sedang Disewa' }}
                            </span>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('cars.show', $car) }}" class="flex-1 text-center bg-gray-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
                                Lihat Detail
                            </a>
                            @if($car->status === 'available')
                                <a href="{{ route('bookings.create', ['car' => $car->id]) }}" class="flex-1 text-center bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                    Pesan
                                </a>
                            @else
                                <button disabled class="flex-1 text-center bg-gray-300 text-gray-500 py-2 rounded-lg text-sm font-semibold cursor-not-allowed">
                                    Tidak Tersedia
                                </button>
                            @endif
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