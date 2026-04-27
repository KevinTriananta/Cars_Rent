<section class="space-y-6">
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Hapus Akun</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Yakin ingin menghapus akun?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Semua data akun akan dihapus permanen. Masukkan password untuk mengonfirmasi penghapusan akun.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-0 border-b-2 border-gray-300 focus:border-blue-500 focus:ring-0 rounded-none bg-transparent"
                    placeholder="Password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-danger-button class="ms-3" x-data x-on:click.prevent="window.CarsRentUI?.confirm({title: 'Hapus akun?', text: 'Akun akan dihapus permanen.', confirmLabel: 'Hapus', onConfirm: () => $el.closest('form').submit()})">
                    Hapus Akun
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
