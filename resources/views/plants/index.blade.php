@extends('layouts.app')

@section('title', 'All Plants — FloraFetch')

@section('content')

{{-- Hero Banner --}}
<div class="bg-gradient-to-r from-flora-700 to-flora-800 text-white rounded-2xl px-8 py-10 mb-8 text-center">
    <h1 class="text-3xl font-bold mb-2">Find Your Perfect Green Companion</h1>
    <p class="text-flora-100">Delivery to your doorstep. Cash on Delivery available.</p>

    {{-- Search bar --}}
    <form method="GET" action="{{ route('plants.index') }}" class="mt-4 flex max-w-md mx-auto gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search plants..."
               class="flex-1 px-4 py-2 rounded-lg text-gray-800 text-sm focus:outline-none">
        <button class="bg-white text-flora-700 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-flora-50">Search</button>
    </form>
</div>

<div class="flex gap-6">

    {{-- ── FILTER SIDEBAR ──────────────────────────────────────────────────── --}}
    <aside class="w-56 shrink-0">
        <form method="GET" action="{{ route('plants.index') }}">
            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm sticky top-20">
                <h2 class="font-bold text-gray-700 mb-4">Filter Plants</h2>

                {{-- Category --}}
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Category</label>
                    <select name="category" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sunlight --}}
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">☀️ Sunlight</label>
                    <select name="sunlight" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                        <option value="">Any Sunlight</option>
                        @foreach($sunlightOptions as $opt)
                            <option value="{{ $opt }}" {{ request('sunlight') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Watering --}}
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">💧 Watering Need</label>
                    <select name="watering" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                        <option value="">Any Watering</option>
                        @foreach($wateringOptions as $opt)
                            <option value="{{ $opt }}" {{ request('watering') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-flora-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-flora-700 transition">
                    Apply Filters
                </button>

                @if(request()->hasAny(['category','sunlight','watering','search']))
                    <a href="{{ route('plants.index') }}" class="block text-center mt-2 text-xs text-gray-500 hover:text-red-500">
                        ✕ Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </aside>

    {{-- ── PLANT GRID ───────────────────────────────────────────────────────── --}}
    <div class="flex-1">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500">{{ $plants->total() }} plants found</p>
        </div>

        @if($plants->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <p class="text-5xl mb-4">🌵</p>
                <p class="text-lg font-medium">No plants found</p>
                <p class="text-sm mt-1">Try adjusting your filters</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($plants as $plant)
                    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition group">

                        {{-- Plant image --}}
                        <a href="{{ route('plants.show', $plant) }}">
                            <div class="h-40 bg-flora-50 flex items-center justify-center overflow-hidden">
                                @if($plant->image_url)
                                    <img src="{{ asset('storage/' . $plant->image_url) }}"
                                         alt="{{ $plant->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <span class="text-5xl">🌿</span>
                                @endif
                            </div>
                        </a>

                        <div class="p-3">
                            <a href="{{ route('plants.show', $plant) }}">
                                <h3 class="font-semibold text-gray-800 text-sm leading-tight hover:text-flora-700 transition">{{ $plant->name }}</h3>
                            </a>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $plant->category }}</p>

                            {{-- Care icons --}}
                            <div class="flex gap-2 mt-2 text-xs text-gray-500">
                                <span title="Sunlight">☀️ {{ $plant->sunlight_requirement }}</span>
                            </div>
                            <div class="flex gap-2 text-xs text-gray-500">
                                <span title="Watering">💧 {{ $plant->watering_need }}</span>
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                <span class="font-bold text-flora-700 text-sm">PKR {{ number_format($plant->price, 0) }}</span>
                            </div>

                            {{-- Add to cart --}}
                            @auth
                                <form method="POST" action="{{ route('cart.add', $plant) }}" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="w-full bg-flora-600 text-white text-xs py-1.5 rounded-lg hover:bg-flora-700 transition font-medium">
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block mt-2 text-center w-full bg-flora-50 text-flora-700 text-xs py-1.5 rounded-lg hover:bg-flora-100 transition font-medium border border-flora-200">
                                    Login to Buy
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $plants->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

@endsection
