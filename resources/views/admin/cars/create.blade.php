@extends('layouts.custom')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6 rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
        <div>
            <h1 class="text-3xl font-semibold text-gray-900">Tambah Mobil </h1>
            <p class="mt-2 text-sm text-gray-500">Segera isi dan lengkapi informasi mobil. </p>
        </div>

        <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-2 block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100" />
                @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                <input id="brand" name="brand" type="text" value="{{ old('brand') }}" required class="mt-2 block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100" />
                @error('brand') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label for="price_per_day" class="block text-sm font-medium text-gray-700">Harga per Hari</label>
                    <input id="price_per_day" name="price_per_day" type="number" min="0" value="{{ old('price_per_day') }}" required class="mt-2 block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100" />
                    @error('price_per_day') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status Mobil</label>
                    <select id="status" name="status" required class="mt-2 block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="rented" {{ old('status') === 'rented' ? 'selected' : '' }}>Rented</option>
                    </select>
                    @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Mobil</label>
                <div class="mt-2">
                    <input id="image" name="image" type="file" accept="image/*" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    <p class="mt-2 text-xs text-gray-500">Tipe file: JPEG, PNG, JPG, GIF. Maksimal: 2MB</p>
                </div>
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="preview" src="" alt="Preview" class="w-full max-w-xs h-40 object-cover rounded-2xl border border-gray-300" />
                </div>
                @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center justify-center rounded-full border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Batalkan</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Simpan Mobil</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('preview').src = event.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection