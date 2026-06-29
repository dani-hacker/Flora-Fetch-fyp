<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FloraFetch — Your Green Companion')</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        flora: {
                            50:  '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    {{-- ── NAVBAR ────────────────────────────────────────────────────────────── --}}
    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('plants.index') }}" class="flex items-center gap-2">
                    <span class="text-2xl font-bold text-flora-700">🌿 FloraFetch</span>
                </a>

                {{-- Nav Links --}}
                <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
                    <a href="{{ route('plants.index') }}" class="hover:text-flora-700 transition">All Plants</a>
                    <a href="{{ route('plants.index', ['category' => 'Indoor']) }}" class="hover:text-flora-700 transition">Indoor</a>
                    <a href="{{ route('plants.index', ['category' => 'Outdoor']) }}" class="hover:text-flora-700 transition">Outdoor</a>
                    <a href="{{ route('plants.index', ['category' => 'Succulents']) }}" class="hover:text-flora-700 transition">Succulents</a>
                    <a href="{{ route('plants.index', ['category' => 'Herbs']) }}" class="hover:text-flora-700 transition">Herbs</a>
                </div>

                {{-- Right side --}}
                <div class="flex items-center gap-4">
                    @auth
                        {{-- Cart icon with count --}}
                        <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-flora-700">
                            🛒
                            @if(count(session('cart', [])) > 0)
                                <span class="absolute -top-2 -right-2 bg-flora-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ count(session('cart', [])) }}
                                </span>
                            @endif
                        </a>

                        <div class="relative group">
                            <button class="text-sm text-gray-700 hover:text-flora-700 font-medium">
                                {{ Auth::user()->name }} ▾
                            </button>
                            <div class="absolute right-0 mt-1 w-44 bg-white border border-gray-100 rounded-lg shadow-lg hidden group-hover:block">
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-flora-50">My Orders</a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-flora-700 font-semibold hover:bg-flora-50">Admin Dashboard</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-flora-700">Log In</a>
                        <a href="{{ route('register') }}" class="bg-flora-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-flora-700 transition">Sign Up</a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    {{-- ── FLASH MESSAGES ────────────────────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-4 pt-4">
        @if(session('success'))
            <div class="bg-flora-50 border border-flora-200 text-flora-800 px-4 py-3 rounded-lg mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                ❌ {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- ── MAIN CONTENT ──────────────────────────────────────────────────────── --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    {{-- ── FOOTER ────────────────────────────────────────────────────────────── --}}
    <footer class="mt-16 bg-flora-900 text-flora-100 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            <p class="font-semibold text-lg mb-1">🌿 FloraFetch</p>
            <p class="text-flora-300">Find Your Perfect Green Companion. Delivery to your doorstep.</p>
            <p class="mt-4 text-flora-500 text-xs">FYP Project | Shahzaib Haider CH | Supervisor: Muhammad Hassaan</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
