@extends('layouts.custom')

@section('content')
<div class="space-y-8">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pengaturan Profil</h1>
                <p class="mt-2 text-gray-500">Perbarui informasi akun dan kelola detail profil Anda di sini.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-gray-100 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition">Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-semibold text-gray-900">Informasi Akun</h2>
            <p class="mt-2 text-sm text-gray-500">Perbarui nama, email, dan informasi dasar akun Anda.</p>
            <div class="mt-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-semibold text-gray-900">Ubah Password</h2>
                <p class="mt-2 text-sm text-gray-500">Ganti password lama jika ingin meningkatkan keamanan akun.</p>
                <div class="mt-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-red-100 p-8">
                <h2 class="text-xl font-semibold text-gray-900">Hapus Akun</h2>
                <p class="mt-2 text-sm text-gray-500">Jika ingin menonaktifkan akun, Anda dapat menghapus pengguna secara permanen.</p>
                <div class="mt-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
