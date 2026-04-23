<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cars Rent</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    @php
        $isAdminSection = request()->routeIs('admin.dashboard');
        $isAdminCars = request()->routeIs('admin.cars.*');
        $isAdminBookings = request()->routeIs('admin.bookings.*');
        $isUserDashboard = request()->routeIs('dashboard');
        $isUserBookings = request()->routeIs('bookings.*');
        $isUserCars = request()->routeIs('cars.*');
        $isProfilePage = request()->routeIs('profile.*');
        $isLoginPage = request()->routeIs('login');
        $isRegisterPage = request()->routeIs('register');

        $navLinkClass = static function (bool $active = false): string {
            $base = 'inline-flex items-center border-b-2 px-1 pb-4 pt-5 text-sm font-medium transition';

            return $active
                ? $base.' border-blue-600 text-gray-900'
                : $base.' border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700';
        };

        $mobileNavLinkClass = static function (bool $active = false): string {
            $base = 'block border-b-2 px-1 py-3 text-sm font-medium transition';

            return $active
                ? $base.' border-blue-600 text-gray-900'
                : $base.' border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-900';
        };
    @endphp

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4 md:py-0">
                <div class="flex items-center gap-2">
                    <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-2 hover:opacity-80 transition">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">@</span>
                        </div>
                        <span class="text-base sm:text-lg font-bold text-gray-900">Cars Rent</span>
                    </a>
                </div>

                <button id="mobile-menu-button" type="button" aria-expanded="false" class="inline-flex items-center justify-center rounded-md border border-gray-200 p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 md:hidden">
                    <span class="sr-only">Toggle navigation</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="hidden md:flex md:items-center md:space-x-8">
                    @if(Auth::check())
                        <div class="flex items-center gap-x-5">
                            @if(!Auth::user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="{{ $navLinkClass($isUserDashboard) }}">Home</a>
                                <a href="{{ route('bookings.index') }}" class="{{ $navLinkClass($isUserBookings) }}">My Booking</a>
                                <a href="{{ route('cars.index') }}" class="{{ $navLinkClass($isUserCars) }}">Cars & Rates</a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="{{ $navLinkClass($isAdminSection) }}">Admin</a>
                                <a href="{{ route('admin.cars.index') }}" class="{{ $navLinkClass($isAdminCars) }}">Cars</a>
                                <a href="{{ route('admin.bookings.index') }}" class="{{ $navLinkClass($isAdminBookings) }}">Booking List</a>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 sm:gap-4">
                            <a href="{{ route('profile.edit') }}" class="flex min-w-0 items-center gap-2 border-b-2 pb-4 pt-5 transition {{ $isProfilePage ? 'border-blue-600 text-gray-900' : 'border-transparent text-gray-700 hover:border-gray-300 hover:text-gray-900' }}">
                                <span class="max-w-[120px] truncate text-sm font-medium sm:max-w-none sm:text-base">{{ Auth::user()->name }}</span>
                                <img class="h-10 w-10 rounded-full object-cover border border-blue-500" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D8ABC&color=fff" alt="Profile">
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-700">Logout</button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-6">
                            <a href="{{ route('login') }}" class="{{ $navLinkClass($isLoginPage) }}">Login</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center rounded-full px-5 py-2.5 text-sm font-semibold transition {{ $isRegisterPage ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Register</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden border-t border-gray-200 md:hidden">
            <div class="px-4 py-4 space-y-4">
                @if(Auth::check())
                    @if(!Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="{{ $mobileNavLinkClass($isUserDashboard) }}">Home</a>
                        <a href="{{ route('bookings.index') }}" class="{{ $mobileNavLinkClass($isUserBookings) }}">My Booking</a>
                        <a href="{{ route('cars.index') }}" class="{{ $mobileNavLinkClass($isUserCars) }}">Cars & Rates</a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="{{ $mobileNavLinkClass($isAdminSection) }}">Admin</a>
                        <a href="{{ route('admin.cars.index') }}" class="{{ $mobileNavLinkClass($isAdminCars) }}">Cars</a>
                        <a href="{{ route('admin.bookings.index') }}" class="{{ $mobileNavLinkClass($isAdminBookings) }}">Booking List</a>
                    @endif

                    <div class="pt-4 border-t border-gray-200">
                        <a href="{{ route('profile.edit') }}" class="{{ $mobileNavLinkClass($isProfilePage) }}">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full border-b-2 border-transparent px-1 py-3 text-left text-sm font-medium text-gray-700 transition hover:border-gray-300 hover:text-gray-900">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="{{ $mobileNavLinkClass(request()->routeIs('login')) }}">Login</a>
                    <a href="{{ route('register') }}" class="{{ $mobileNavLinkClass(request()->routeIs('register')) }}">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <main class="py-6 sm:py-8 md:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <div id="toast-container" class="pointer-events-none fixed right-4 top-4 z-[90] flex w-[calc(100%-2rem)] max-w-sm flex-col gap-3 sm:w-full"></div>

    <div id="confirm-dialog" class="fixed inset-0 z-[100] hidden items-center justify-center bg-gray-900/50 px-4">
        <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
            <h2 id="confirm-dialog-title" class="text-xl font-semibold text-gray-900">Konfirmasi tindakan</h2>
            <p id="confirm-dialog-text" class="mt-3 text-sm leading-6 text-gray-600"></p>
            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button type="button" id="confirm-dialog-cancel" class="inline-flex items-center justify-center rounded-xl bg-gray-100 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-200">
                    Batal
                </button>
                <button type="button" id="confirm-dialog-submit" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');
            if (button && menu) {
                button.addEventListener('click', function () {
                    menu.classList.toggle('hidden');
                    const expanded = button.getAttribute('aria-expanded') === 'true';
                    button.setAttribute('aria-expanded', String(!expanded));
                });
            }

            const toastContainer = document.getElementById('toast-container');
            const confirmDialog = document.getElementById('confirm-dialog');
            const confirmTitle = document.getElementById('confirm-dialog-title');
            const confirmText = document.getElementById('confirm-dialog-text');
            const confirmSubmit = document.getElementById('confirm-dialog-submit');
            const confirmCancel = document.getElementById('confirm-dialog-cancel');
            let confirmHandler = null;

            const createToast = (message, type = 'success') => {
                if (!toastContainer || !message) return;

                const styles = {
                    success: 'border-green-200 bg-green-50 text-green-800',
                    error: 'border-red-200 bg-red-50 text-red-800',
                    info: 'border-blue-200 bg-blue-50 text-blue-800',
                };

                const toast = document.createElement('div');
                toast.className = `pointer-events-auto translate-y-0 rounded-2xl border px-4 py-4 shadow-lg transition ${styles[type] || styles.info}`;
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 h-2.5 w-2.5 rounded-full ${type === 'error' ? 'bg-red-500' : type === 'success' ? 'bg-green-500' : 'bg-blue-500'}"></div>
                        <div class="flex-1 text-sm font-medium leading-6">${message}</div>
                        <button type="button" class="toast-close text-xs font-semibold opacity-70 transition hover:opacity-100">Tutup</button>
                    </div>
                `;

                toastContainer.appendChild(toast);

                const removeToast = () => {
                    toast.classList.add('opacity-0', 'translate-y-1');
                    setTimeout(() => toast.remove(), 180);
                };

                toast.querySelector('.toast-close')?.addEventListener('click', removeToast);
                setTimeout(removeToast, 4000);
            };

            const closeConfirm = () => {
                confirmDialog?.classList.add('hidden');
                confirmDialog?.classList.remove('flex');
                confirmHandler = null;
                document.body.classList.remove('overflow-hidden');
            };

            const openConfirm = ({ title, text, confirmLabel, onConfirm }) => {
                if (!confirmDialog) return;
                confirmTitle.textContent = title || 'Konfirmasi tindakan';
                confirmText.textContent = text || 'Pastikan Anda yakin sebelum melanjutkan.';
                confirmSubmit.textContent = confirmLabel || 'Lanjutkan';
                confirmHandler = onConfirm || null;
                confirmDialog.classList.remove('hidden');
                confirmDialog.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            };

            confirmCancel?.addEventListener('click', closeConfirm);
            confirmDialog?.addEventListener('click', function (event) {
                if (event.target === confirmDialog) {
                    closeConfirm();
                }
            });
            confirmSubmit?.addEventListener('click', function () {
                if (typeof confirmHandler === 'function') {
                    confirmHandler();
                }
                closeConfirm();
            });

            window.CarsRentUI = {
                showToast: createToast,
                confirm: openConfirm,
            };

            const flashSuccess = @json(session('success'));
            const flashError = @json(session('error'));

            if (flashSuccess) createToast(flashSuccess, 'success');
            if (flashError) createToast(flashError, 'error');

            document.querySelectorAll('form').forEach((form) => {
                form.addEventListener('submit', function (event) {
                    const submitter = event.submitter;
                    const shouldConfirm = form.dataset.confirmForm === 'true' || !!submitter?.dataset.confirmTitle;

                    if (!shouldConfirm) {
                        return;
                    }

                    if (form.dataset.confirmed === 'true') {
                        form.dataset.confirmed = 'false';
                        return;
                    }

                    event.preventDefault();
                    openConfirm({
                        title: submitter?.dataset.confirmTitle || form.dataset.confirmTitle || 'Lanjutkan aksi ini?',
                        text: submitter?.dataset.confirmText || form.dataset.confirmText || 'Perubahan ini akan langsung diproses.',
                        confirmLabel: submitter?.dataset.confirmButton || form.dataset.confirmButton || 'Lanjutkan',
                        onConfirm: () => {
                            form.dataset.confirmed = 'true';
                            form.requestSubmit();
                        },
                    });
                });
            });

            document.querySelectorAll('[data-confirm-link="true"]').forEach((link) => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    openConfirm({
                        title: link.dataset.confirmTitle || 'Buka tautan ini?',
                        text: link.dataset.confirmText || 'Anda akan diarahkan ke halaman lain.',
                        confirmLabel: link.dataset.confirmButton || 'Buka',
                        onConfirm: () => {
                            window.open(link.href, link.target || '_self', link.target === '_blank' ? 'noopener,noreferrer' : undefined);
                            createToast('Membuka WhatsApp...', 'info');
                        },
                    });
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
