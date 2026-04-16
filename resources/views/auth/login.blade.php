@extends('layouts.custom')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md bg-white border border-gray-200 rounded-3xl shadow-xl p-8">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-gray-900">Cars Rent</a>
            <p class="mt-3 text-gray-500">Masuk untuk mengelola booking dan melihat tanggal pengembalian Anda.</p>
        </div>

        @if(session('status'))
            <div class="mb-5 rounded-3xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="mt-2 block w-full rounded-3xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="mt-2 block w-full rounded-3xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between text-sm text-gray-600">
                <label class="inline-flex items-center gap-2">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    <span>Ingat Saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="font-semibold text-blue-600 hover:text-blue-700">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="w-full rounded-3xl bg-blue-600 px-5 py-3 text-sm font-semibold uppercase tracking-wider text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">Masuk</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">Daftar sekarang</a></p>
    </div>
</div>
@endsection
