@extends('layouts.custom')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-2xl sm:text-3xl uppercase tracking-[0.16em] sm:tracking-[0.2em] text-blue-600 font-semibold">Admin Dashboard</p>
                <p class="mt-2 text-gray-500 max-w-2xl">Pantau pendapatan, booking harian, status mobil, dan reminder penting secara cepat.</p>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <div class="rounded-3xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-6 text-center shadow-md">
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-600 font-medium">Total Mobil</p>
                    <p class="mt-3 text-3xl font-extrabold text-blue-800">{{ $cars }}</p>
                </div>
                <div class="rounded-3xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200 p-6 text-center shadow-md">
                    <p class="text-xs uppercase tracking-[0.2em] text-green-600 font-medium">Total Booking</p>
                    <p class="mt-3 text-3xl font-extrabold text-green-800">{{ $bookings }}</p>
                </div>
                <div class="rounded-3xl bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 p-6 text-center shadow-md">
                    <p class="text-xs uppercase tracking-[0.2em] text-yellow-600 font-medium">Pending</p>
                    <p class="mt-3 text-3xl font-extrabold text-yellow-800">{{ $pending }}</p>
                </div>
                <div class="rounded-3xl bg-gradient-to-br from-red-50 to-red-100 border border-red-200 p-6 text-center shadow-md">
                    <p class="text-xs uppercase tracking-[0.2em] text-red-600 font-medium">Booking Aktif</p>
                    <p class="mt-3 text-3xl font-extrabold text-red-800">{{ $rentedCars }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 p-6 shadow-md">
                <p class="text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                <p class="mt-4 text-3xl font-bold text-gray-900">Rp {{ number_format($incomeToday, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-3xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 p-6 shadow-md">
                <p class="text-sm font-medium text-gray-600">Pendapatan Bulan Ini</p>
                <p class="mt-4 text-3xl font-bold text-gray-900">Rp {{ number_format($incomeMonth, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-3xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 p-6 shadow-md">
                <p class="text-sm font-medium text-gray-600">Pendapatan Tahun Ini</p>
                <p class="mt-4 text-3xl font-bold text-gray-900">Rp {{ number_format($incomeYear, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.8fr_1fr]">
            <div class="space-y-6">
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-md">
                    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Booking Hari Ini</h2>
                            <p class="mt-1 text-sm text-gray-500">Fokus operasional untuk hari ini.</p>
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">{{ $todayBookings->count() }} aktif</span>
                    </div>

                    @if($todayBookings->isEmpty())
                        <div class="mt-6 rounded-3xl bg-gray-50 p-6 text-center text-gray-500">Tidak ada booking untuk hari ini.</div>
                    @else
                        <div class="mt-6 space-y-4">
                            @foreach($todayBookings as $booking)
                                <div class="rounded-3xl border border-gray-100 bg-gray-50 p-4">
                                    <div class="flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $booking->car->name }} · {{ $booking->car->brand }}</p>
                                        </div>
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] 
                                            {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                    <p class="mt-3 text-sm text-gray-500">Mulai: {{ \Illuminate\Support\Carbon::parse($booking->start_date)->format('d M Y') }} · Selesai: {{ \Illuminate\Support\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-md">
                    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h2>
                            <p class="mt-1 text-sm text-gray-500">Ringkasan aktivitas terkini di sistem.</p>
                        </div>
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-700">{{ $activityFeed->count() }} item</span>
                    </div>

                    <div class="mt-6 space-y-4">
                        @forelse($activityFeed as $activity)
                            <div class="rounded-3xl border border-gray-100 bg-gray-50 p-4">
                                <div class="flex flex-col items-start justify-between gap-2 sm:flex-row sm:gap-4">
                                    <p class="text-sm text-gray-700">{{ $activity['message'] }}</p>
                                    <span class="text-xs text-gray-400">{{ \Illuminate\Support\Carbon::parse($activity['time'])->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada aktivitas terbaru.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-md">
                    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Status Mobil</h2>
                            <p class="mt-1 text-sm text-gray-500">Ringkasan ketersediaan mobil.</p>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl bg-blue-50 p-5">
                            <p class="text-sm text-blue-700">🟢 Tersedia</p>
                            <p class="mt-3 text-2xl sm:text-3xl font-semibold text-blue-900">{{ $carStatuses['available'] }}</p>
                        </div>
                        <div class="rounded-3xl bg-red-50 p-5">
                            <p class="text-sm text-red-700">🔴 Disewa</p>
                            <p class="mt-3 text-2xl sm:text-3xl font-semibold text-red-900">{{ $carStatuses['rented'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-md">
                    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Reminder & Alert</h2>
                            <p class="mt-1 text-sm text-gray-500">Notifikasi penting terkait aktivitas sistem.</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-4">
                        @foreach($reminders as $reminder)
                            <div class="flex items-start gap-3 rounded-3xl border border-gray-100 bg-gray-50 p-4">
                                <div>
                                    <p class="text-sm text-gray-700">{{ $reminder['message'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Kelola Mobil</a>
            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center justify-center rounded-full bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800">Kelola Booking</a>
        </div>
    </div>
@endsection
