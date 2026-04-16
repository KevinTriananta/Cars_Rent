@extends('layouts.custom')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Kelola Booking</h1>
                <p class="mt-2 text-sm text-gray-500">Lihat detail user, tanggal sewa, mobil, total harga, dan kelola status booking secara real-time.</p>
            </div>
        </div>

        <form id="realBulkForm" method="POST" action="{{ route('admin.bookings.bulk') }}" style="display: none;">
            @csrf
            <div id="bulkInputs"></div>
            <input type="hidden" name="action" id="bulkActionValue">
        </form>

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
            @if($bookings->count() > 0)
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="selectAll" class="ml-2 text-sm text-gray-700">Pilih Semua</label>
                        </div>
                        <div class="flex gap-2" id="bulkActions" style="display: none;">
                            <button type="button" onclick="submitBulk('approve')" 
                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                Setujui Terpilih
                            </button>
                            <button type="button" onclick="submitBulk('reject')" 
                                    class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                Tolak Terpilih
                            </button>
                            <button type="button" onclick="submitBulk('pending')" 
                                    class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                                Set Pending
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
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Mobil</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" value="{{ $booking->id }}" class="booking-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $booking->user->name }}
                                    <span class="block text-xs text-gray-500">{{ $booking->user->email }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $booking->car->name }}
                                    <span class="block text-xs text-gray-500">{{ $booking->car->brand }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $booking->start_date->format('d M Y') }} - {{ $booking->end_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold 
                                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $booking->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        @if($booking->status !== 'approved')
                                            <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="rounded-full bg-green-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-green-700">Setujui</button>
                                            </form>
                                        @endif

                                        @if($booking->status !== 'rejected')
                                            <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="rounded-full bg-red-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-700">Tolak</button>
                                            </form>
                                        @endif

                                        @if($booking->status !== 'pending')
                                            <form action="{{ route('admin.bookings.pending', $booking) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="rounded-full bg-yellow-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-yellow-600">Pending</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-12 text-center text-sm text-gray-500">Tidak ada booking yang ditemukan.</div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Fungsi untuk mensubmit Bulk Action
    function submitBulk(action) {
        const checkboxes = document.querySelectorAll('.booking-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Pilih minimal satu booking!');
            return;
        }

        const form = document.getElementById('realBulkForm');
        const inputsContainer = document.getElementById('bulkInputs');
        const actionInput = document.getElementById('bulkActionValue');

        // Reset inputs sebelumnya
        inputsContainer.innerHTML = '';
        actionInput.value = action;

        // Tambahkan ID yang dipilih ke form
        checkboxes.forEach(cb => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'booking_ids[]';
            hiddenInput.value = cb.value;
            inputsContainer.appendChild(hiddenInput);
        });

        form.submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const headerCheckbox = document.getElementById('headerCheckbox');
        const bookingCheckboxes = document.querySelectorAll('.booking-checkbox');
        const bulkActions = document.getElementById('bulkActions');

        function updateBulkActionsVisibility() {
            const checkedBoxes = document.querySelectorAll('.booking-checkbox:checked');
            bulkActions.style.display = checkedBoxes.length > 0 ? 'flex' : 'none';
        }

        function syncCheckboxes(masterCheckbox) {
            bookingCheckboxes.forEach(checkbox => {
                checkbox.checked = masterCheckbox.checked;
            });
            selectAllCheckbox.checked = masterCheckbox.checked;
            headerCheckbox.checked = masterCheckbox.checked;
            updateBulkActionsVisibility();
        }

        headerCheckbox.addEventListener('change', function() { syncCheckboxes(this); });
        selectAllCheckbox.addEventListener('change', function() { syncCheckboxes(this); });

        bookingCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const total = bookingCheckboxes.length;
                const checked = document.querySelectorAll('.booking-checkbox:checked').length;
                
                headerCheckbox.checked = (checked === total);
                selectAllCheckbox.checked = (checked === total);
                headerCheckbox.indeterminate = (checked > 0 && checked < total);
                selectAllCheckbox.indeterminate = (checked > 0 && checked < total);
                
                updateBulkActionsVisibility();
            });
        });
    });
</script>
@endsection