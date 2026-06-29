@extends('layouts.app')

@section('title', $plant->name . ' — FloraFetch')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 gap-10">

    {{-- Plant Image --}}
    <div class="bg-flora-50 rounded-2xl flex items-center justify-center min-h-80 overflow-hidden">
        @if($plant->image_url)
            <img src="{{ asset('storage/' . $plant->image_url) }}" alt="{{ $plant->name }}" class="w-full h-full object-cover rounded-2xl">
        @else
            <span class="text-9xl">🌿</span>
        @endif
    </div>

    {{-- Details --}}
    <div>
        <p class="text-sm text-flora-600 font-medium mb-1">{{ $plant->category }}</p>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $plant->name }}</h1>
        <p class="text-2xl font-bold text-flora-700 mb-4">PKR {{ number_format($plant->price, 0) }}</p>

        {{-- Care Instructions --}}
        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4">
                <p class="text-sm font-bold text-yellow-700 mb-1">☀️ Sunlight</p>
                <p class="text-sm text-gray-700">{{ $plant->sunlight_requirement }}</p>
            </div>
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                <p class="text-sm font-bold text-blue-700 mb-1">💧 Watering</p>
                <p class="text-sm text-gray-700">{{ $plant->watering_need }} watering need</p>
            </div>
        </div>

        {{-- Description --}}
        @if($plant->description)
            <p class="text-gray-600 text-sm mb-6">{{ $plant->description }}</p>
        @endif

        {{-- Stock --}}
        <p class="text-sm mb-4">
            @if($plant->isInStock())
                <span class="text-flora-600 font-medium">✅ In Stock ({{ $plant->stock_quantity }} available)</span>
            @else
                <span class="text-red-500 font-medium">❌ Out of Stock</span>
            @endif
        </p>

        {{-- Add to Cart --}}
        @auth
            @if($plant->isInStock())
                <form method="POST" action="{{ route('cart.add', $plant) }}" class="flex gap-3 items-center">
                    @csrf
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                        <button type="button" onclick="adjustQty(-1)" class="px-3 py-2 text-gray-500 hover:bg-gray-50">−</button>
                        <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $plant->stock_quantity }}"
                               class="w-14 text-center border-x border-gray-200 py-2 text-sm focus:outline-none">
                        <button type="button" onclick="adjustQty(1)" class="px-3 py-2 text-gray-500 hover:bg-gray-50">+</button>
                    </div>
                    <button type="submit" class="flex-1 bg-flora-600 text-white py-3 rounded-xl font-semibold hover:bg-flora-700 transition">
                        🛒 Add to Cart
                    </button>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="block text-center bg-flora-600 text-white py-3 rounded-xl font-semibold hover:bg-flora-700 transition">
                Log in to Add to Cart
            </a>
        @endauth
    </div>
</div>

{{-- Related Plants --}}
@if($related->count())
    <div class="mt-14">
        <h2 class="text-xl font-bold text-gray-800 mb-5">Related Plants</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($related as $rel)
                <a href="{{ route('plants.show', $rel) }}"
                   class="bg-white border border-gray-100 rounded-xl p-3 hover:shadow-md transition text-center">
                    <div class="text-4xl mb-2">🌿</div>
                    <p class="text-sm font-medium text-gray-800">{{ $rel->name }}</p>
                    <p class="text-flora-700 font-bold text-sm mt-1">PKR {{ number_format($rel->price, 0) }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
function adjustQty(delta) {
    const input = document.getElementById('qty');
    const max = parseInt(input.max);
    const newVal = Math.max(1, Math.min(max, parseInt(input.value) + delta));
    input.value = newVal;
}
</script>
@endpush
