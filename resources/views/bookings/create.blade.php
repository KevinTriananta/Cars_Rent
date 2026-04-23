@extends('layouts.custom')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pesan Mobil</h1>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white p-5 sm:p-8 rounded-3xl shadow-sm border border-gray-100">
        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4" id="bookingForm">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Mobil</label>
                <select name="car_id" id="carSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('car_id') border-red-500 @enderror" required onchange="updatePrice()">
                    <option value="">-- Pilih Mobil --</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" data-price="{{ $car->price_per_day }}" data-calendar-url="{{ route('cars.calendar', $car) }}" {{ (string) old('car_id', $selectedCarId ?? '') === (string) $car->id ? 'selected' : '' }}>
                            {{ $car->name }} ({{ $car->brand }}) - Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/hari
                        </option>
                    @endforeach
                </select>
                @error('car_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                
                @if($cars->isEmpty())
                    <p class="text-red-600 text-sm mt-2">Tidak ada mobil yang tersedia saat ini</p>
                @endif

                <p class="text-xs text-gray-500 mt-2">
                    Cek tanggal merah di kalender sebelum memilih tanggal sewa:
                    <a id="calendarLink" href="#" target="_blank" class="text-blue-600 hover:underline hidden">Lihat kalender mobil</a>
                    <span id="calendarHint">pilih mobil terlebih dahulu.</span>
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="startDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('start_date') border-red-500 @enderror" value="{{ old('start_date') }}" required onchange="calculateTotal()">
                    @error('start_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kembali</label>
                    <input type="date" name="end_date" id="endDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('end_date') border-red-500 @enderror" value="{{ old('end_date') }}" required onchange="calculateTotal()">
                    @error('end_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <span class="text-gray-700 font-medium">Total Harga:</span>
                    <span class="text-2xl font-bold text-blue-600" id="totalPrice">Rp 0</span>
                </div>
                <p class="text-xs text-gray-500 mt-2" id="totalDaysInfo">Total Hari: 0 Hari</p>
                <p class="text-xs text-gray-500 mt-2">Harga dihitung otomatis berdasarkan durasi sewa</p>
            </div>

            <div class="grid grid-cols-1 gap-3 pt-4 sm:grid-cols-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    Konfirmasi Pesanan
                </button>
                <a href="{{ route('bookings.index') }}" class="flex-1 bg-gray-300 text-gray-800 py-3 rounded-lg hover:bg-gray-400 transition font-semibold text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function updatePrice() {
        updateCalendarLink();
        calculateTotal();
    }

function calculateTotal() {
    const carSelect = document.getElementById('carSelect');
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');
    const totalPriceElement = document.getElementById('totalPrice');
    
    // Ambil elemen untuk keterangan hari (kita akan buat elemennya setelah ini)
    const totalDaysElement = document.getElementById('totalDaysInfo');

    const selectedOption = carSelect.options[carSelect.selectedIndex];
    const pricePerDay = parseInt(selectedOption.dataset.price) || 0;
    
    if (startDate.value && endDate.value && pricePerDay > 0) {
        const start = new Date(startDate.value);
        const end = new Date(endDate.value);
        
        // Hitung selisih milidetik lalu ubah ke hari
        const diffTime = end - start;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        // Logika +1 agar sinkron dengan Controller Backend (8 ke 9 jadi 2 hari)
        const duration = diffDays + 1;

        if (duration > 0) {
            const total = pricePerDay * duration;
            totalPriceElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            totalDaysElement.textContent = `Total sewa: ${duration} Hari`; // Update keterangan hari
        } else {
            totalPriceElement.textContent = 'Rp 0';
            totalDaysElement.textContent = 'Durasi tidak valid';
        }
    } else {
        totalPriceElement.textContent = 'Rp 0';
    }
}

function updateCalendarLink() {
    const carSelect = document.getElementById('carSelect');
    const link = document.getElementById('calendarLink');
    const hint = document.getElementById('calendarHint');
    const selectedOption = carSelect.options[carSelect.selectedIndex];
    const calendarUrl = selectedOption ? selectedOption.dataset.calendarUrl : null;

    if (calendarUrl) {
        link.href = calendarUrl;
        link.classList.remove('hidden');
        hint.classList.add('hidden');
    } else {
        link.classList.add('hidden');
        hint.classList.remove('hidden');
    }
}

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('startDate').min = today;
    document.getElementById('endDate').min = today;

    updateCalendarLink();
    calculateTotal();
</script>
@endsection
