@extends('layouts.app')

@section('title', 'Your Cart — FloraFetch')

@section('content')

<h1 class="text-2xl font-bold text-gray-800 mb-6">🛒 Your Green Cart</h1>

@if(empty($cart))
    <div class="text-center py-16 text-gray-400">
        <p class="text-6xl mb-4">🌵</p>
        <p class="text-lg font-medium">Your cart is empty</p>
        <a href="{{ route('plants.index') }}" class="mt-4 inline-block bg-flora-600 text-white px-6 py-2 rounded-xl font-medium hover:bg-flora-700 transition">
            Browse Plants
        </a>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Cart Items --}}
        <div class="lg:col-span-2 space-y-3">
            @foreach($cart as $id => $item)
                <div class="bg-white border border-gray-100 rounded-xl p-4 flex items-center gap-4 shadow-sm">
                    <div class="w-16 h-16 bg-flora-50 rounded-lg flex items-center justify-center shrink-0">
                        @if($item['image'])
                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover rounded-lg">
                        @else
                            <span class="text-2xl">🌿</span>
                        @endif
                    </div>

                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 text-sm">{{ $item['name'] }}</p>
                        <p class="text-flora-700 font-bold text-sm">PKR {{ number_format($item['price'], 0) }}</p>
                    </div>

                    {{-- Quantity updater --}}
                    <form method="POST" action="{{ route('cart.update', $id) }}" class="flex items-center gap-1">
                        @csrf @method('PATCH')
                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                   class="w-14 text-center py-1 text-sm focus:outline-none">
                        </div>
                        <button class="text-xs text-flora-600 hover:underline ml-1">Update</button>
                    </form>

                    {{-- Subtotal --}}
                    <p class="font-bold text-gray-800 text-sm w-24 text-right">
                        PKR {{ number_format($item['price'] * $item['quantity'], 0) }}
                    </p>

                    {{-- Remove --}}
                    <form method="POST" action="{{ route('cart.remove', $id) }}">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-600 text-lg">✕</button>
                    </form>
                </div>
            @endforeach

            <div class="text-right">
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf @method('DELETE')
                    <button class="text-xs text-gray-400 hover:text-red-500">Clear Cart</button>
                </form>
            </div>
        </div>

        {{-- Order Summary --}}
        <div>
            <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm sticky top-20">
                <h2 class="font-bold text-gray-800 mb-4">Order Summary</h2>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>PKR {{ number_format($total, 0) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span class="{{ $total >= 5000 ? 'text-flora-600' : 'text-gray-600' }}">
                            {{ $total >= 5000 ? 'Free' : 'PKR 200' }}
                        </span>
                    </div>
                    @if($total < 5000)
                        <p class="text-xs text-flora-600">Free shipping on orders over PKR 5,000!</p>
                    @endif
                    <div class="border-t border-gray-100 pt-2 flex justify-between font-bold text-gray-800 text-base">
                        <span>Total</span>
                        <span>PKR {{ number_format($total < 5000 ? $total + 200 : $total, 0) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout') }}"
                   class="block mt-5 text-center bg-flora-600 text-white py-3 rounded-xl font-semibold hover:bg-flora-700 transition">
                    Proceed to Checkout →
                </a>
            </div>
        </div>
    </div>
@endif

@endsection
