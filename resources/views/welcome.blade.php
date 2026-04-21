<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Rent - Sewa Mobil Mudah & Elegan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-900">
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 hover:opacity-80 transition">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">@</span>
                </div>
                <span class="text-lg font-bold text-gray-900">Cars Rent</span>
            </a>
            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 transition">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 rounded-full bg-blue-600 text-white text-sm font-semibold shadow-md hover:bg-blue-700 hover:shadow-lg transition transform hover:scale-105">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main>
        <section class="relative overflow-hidden bg-white">
            <div class="container mx-auto px-4 py-24 lg:flex lg:items-center lg:justify-between">
                <div class="lg:w-6/12 mb-10 lg:mb-0 ">
                    <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-5xl mb-0">Sewa Mobil Berkualitas</h1>
                    <h1 class="text-5xl font-extrabold tracking-tight text-blue-600 sm:text-5xl mb-6">Harga Terjangkau.</h1>
                    <p class="text-lg leading-8 text-gray-600 mb-10 max-w-lg">Nikmati pengalaman berkendara yang nyaman dengan pilihan kendaraan terbaik dan layanan profesional kami.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('cars.index') }}" class="inline-flex items-center justify-center px-8 py-3 rounded-full bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-700 hover:shadow-xl transition transform hover:scale-105">Lihat Katalog</a>
                    </div>
                </div>
                <div class="lg:w-11/12 ">
                    <div class="relative overflow-hidden rounded-1xl">
                        <img src="{{('LP.png') }}" alt="Mobil rental"class="w-full h-auto object-cover"/>
                    </div>
                </div>
            </div>
        </section>

        <section class="container mx-auto px-4 py-20">
            <div class="grid gap-8 md:grid-cols-3">
                <div class="text-center transition hover:-translate-y-2 hover:shadow-lg rounded-2xl p-8">
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Reservasi Online</h3>
                    <p class="text-gray-600 text-sm">Lakukan pemesanan kapan saja, di mana saja dengan mudah dan cepat melalui platform kami.</p>
                </div>
                <div class="text-center transition hover:-translate-y-2 hover:shadow-lg rounded-2xl p-8">
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Hotline 24/7</h3>
                    <p class="text-gray-600 text-sm">Tim customer service kami siap membantu Anda setiap saat dengan respons yang cepat.</p>
                </div>
                <div class="text-center transition hover:-translate-y-2 hover:shadow-lg rounded-2xl p-8">
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">FAQ & Bantuan</h3>
                    <p class="text-gray-600 text-sm">Temukan jawaban atas pertanyaan Anda di pusat bantuan kami yang lengkap dan informatif.</p>
                </div>
            </div>
        </section>

        <section class="bg-gray-900 py-20 text-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4">Pilihan Mobil Terbaik</h2>
                    <p class="text-lg text-gray-300">Jelajahi koleksi kendaraan premium kami dengan harga yang kompetitif</p>
                </div>
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    @forelse($featuredCars as $car)
                        <a href="{{ route('cars.show', $car) }}" class="group overflow-hidden rounded-2xl bg-gray-800 shadow-lg transition duration-300 hover:shadow-2xl hover:-translate-y-1">
                            <div class="h-48 overflow-hidden bg-gray-700">
                                @if($car->image)
                                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-110" />
                                @else
                                    <div class="h-full w-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm11 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <p class="text-sm text-blue-400 font-semibold uppercase tracking-wide mb-2">{{ $car->brand ?? 'Mobil' }}</p>
                                <h3 class="text-xl font-bold text-white mb-3">{{ $car->name }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-blue-400">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                                    <span class="text-sm text-gray-400">/hari</span>
                                </div>
                                <p class="mt-4 text-sm text-gray-300">{{ ucfirst($car->status ?? 'Tersedia') }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full rounded-2xl border border-gray-700 bg-gray-800 p-10 text-center">
                            <p class="text-gray-300">Tidak ada mobil terbaru yang tersedia saat ini.</p>
                            <a href="{{ route('cars.index') }}" class="mt-6 inline-flex rounded-full border border-blue-600 px-6 py-2 text-sm font-semibold text-blue-400 hover:bg-blue-600 hover:text-white transition">Lihat Katalog Lengkap</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="container mx-auto px-4 py-20">
            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-xl">
                <div class="grid lg:grid-cols-2 lg:items-stretch">
                    <div class="relative min-h-[320px] sm:min-h-[420px] lg:min-h-[560px]">
                        <img src="about-rent.png" alt="Mobil premium Cars Rent" class="h-full w-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/30 via-transparent to-transparent"></div>
                        <div class="absolute left-6 bottom-6 rounded-xl bg-white/95 px-4 py-3 shadow-lg backdrop-blur-sm hover:opacity-0 delay-2s">
                            <p class="text-sm font-semibold text-gray-900">Mobil Premium</p>
                            <p class="text-xs text-gray-600">Bersih, terawat, siap jalan kapan saja.</p>
                        </div>
                    </div>
                    <div class="relative bg-gradient-to-br from-white via-slate-50 to-blue-50 px-6 py-10 sm:px-10 lg:px-14 lg:py-14">
                        <h2 class="text-3xl font-bold leading-tight text-gray-900 mb-6">Mengapa Memilih Cars Rent?</h2>
                        <p class="text-lg leading-relaxed text-gray-700 mb-8">Kami menyediakan pengalaman rental mobil terbaik dengan kondisi berkualitas, harga kompetitif, dan layanan pelanggan 24/7 yang siap membantu setiap kebutuhan perjalanan Anda.</p>
                        <div class="space-y-5 mb-10">
                            <div class="flex items-start gap-4">
                                <div class="mt-1 flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-blue-600">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Mobil Lengkap & Modern</h3>
                                    <p class="text-sm text-gray-600">Pilihan kendaraan dari berbagai tipe dan ukuran untuk kebutuhan harian maupun perjalanan jauh.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="mt-1 flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-blue-600">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Harga Terjangkau</h3>
                                    <p class="text-sm text-gray-600">Tarif transparan dan kompetitif tanpa biaya tersembunyi.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="mt-1 flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-blue-600">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Layanan Terpercaya</h3>
                                    <p class="text-sm text-gray-600">Tim customer service responsif 24/7 siap membantu kapan pun Anda butuh.</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('cars.index') }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-8 py-3 font-semibold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-xl">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="border-t border-gray-200 bg-white py-8">
        <div class="container mx-auto px-4 text-center text-sm text-gray-600">
            <p class="font-semibold text-gray-900">Cars Rent</p>
            <p class="mt-2">© {{ date('Y') }} Cars Rent. Semua hak dilindungi.</p>
        </div>
    </footer>
</body>
</html>
