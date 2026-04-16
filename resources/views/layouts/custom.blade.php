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

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center bg-gray-200 px-6 py-2 rounded font-bold tracking-widest text-gray-600 hover:bg-gray-300 transition">
                        Cars Rent
                    </a>
                    
                    @if(Auth::check())
                        <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                            @if(!Auth::user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="text-gray-900 inline-flex items-center px-1 pt-1 text-sm font-medium">Home</a>
                                <a href="{{ route('bookings.index') }}" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">My Booking</a>
                                <a href="{{ route('cars.index') }}" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">Cars & Rates</a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">Admin</a>
                                <a href="{{ route('admin.cars.index') }}" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">Cars</a>
                                <a href="{{ route('admin.bookings.index') }}" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">Booking List</a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center space-x-4">
                    @if(Auth::check())
                        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 hover:opacity-80 transition">
                            <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-blue-500" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=0D8ABC&color=fff" alt="Profile">
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Logout</button>
                        </form>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Login</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-full bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">Register</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-green-200 bg-green-50 px-4 py-4 text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-4 py-4 text-red-800 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>