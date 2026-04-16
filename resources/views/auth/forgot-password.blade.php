@extends('layouts.custom')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md bg-white border border-gray-200 rounded-3xl shadow-xl p-8">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-3xl font-bold text-gray-900">Cars Rent</a>
            <p class="mt-3 text-gray-500">Masukkan email Anda dan kami akan mengirimkan tautan untuk mereset password.</p>
        </div>

        @if(session('status'))
            <div class="mb-5 rounded-3xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-2 block w-full rounded-3xl border border-gray-200 bg-gray-50 px-4 py-3 text-gray-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button type="submit" class="w-full rounded-3xl bg-blue-600 px-5 py-3 text-sm font-semibold uppercase tracking-wider text-white shadow-lg shadow-blue-200 transition hover:bg-blue-700">Kirim tautan reset</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">Ingat password? <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Login</a></p>
    </div>
</div>
@endsection
