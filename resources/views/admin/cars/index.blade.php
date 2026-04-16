@extends('layouts.custom')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Kelola Mobil</h1>
                <p class="mt-2 text-sm text-gray-500"></p>
            </div>
            <a href="{{ route('admin.cars.create') }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">+ Tambah Mobil Baru</a>
        </div>

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            <!-- Bulk Actions Form -->
            <form id="bulkForm" method="POST" action="{{ route('admin.cars.bulk') }}">
                @csrf
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="selectAll" class="ml-2 text-sm text-gray-700">Pilih Semua</label>
                        </div>
                        <div class="flex gap-2" id="bulkActions" style="display: none;">
                            <button type="submit" name="action" value="delete" onclick="return confirm('Hapus mobil yang dipilih?')" 
                                    class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                Hapus Terpilih
                            </button>
                            <button type="submit" name="action" value="available" 
                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                Set Available
                            </button>
                            <button type="submit" name="action" value="rented" 
                                    class="bg-orange-600 text-white px-3 py-1 rounded text-sm hover:bg-orange-700">
                                Set Rented
                            </button>
                        </div>
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 w-12">
                                <input type="checkbox" id="headerCheckbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Merk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Harga / Hari</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($cars as $car)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="car_ids[]" value="{{ $car->id }}" class="car-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $car->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $car->brand }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold 
                                        {{ $car->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($car->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('admin.cars.edit', $car) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline-block ml-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus mobil ini?')" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">Belum ada mobil terdaftar. Tambahkan mobil baru untuk tampil di halaman user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const headerCheckbox = document.getElementById('headerCheckbox');
    const carCheckboxes = document.querySelectorAll('.car-checkbox');
    const bulkActions = document.getElementById('bulkActions');

    function updateBulkActionsVisibility() {
        const checkedBoxes = document.querySelectorAll('.car-checkbox:checked');
        bulkActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
    }

    function updateSelectAllState() {
        const totalCheckboxes = carCheckboxes.length;
        const checkedCheckboxes = document.querySelectorAll('.car-checkbox:checked').length;
        selectAllCheckbox.checked = totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes;
        selectAllCheckbox.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
    }

    // Header checkbox functionality
    headerCheckbox.addEventListener('change', function() {
        carCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsVisibility();
    });

    // "Select All" checkbox functionality
    selectAllCheckbox.addEventListener('change', function() {
        headerCheckbox.checked = this.checked;
        carCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsVisibility();
    });

    // Individual checkboxes
    carCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkActionsVisibility();
        });
    });
});
</script>
@endsection
    