@extends('layouts.app')

@section('title', 'Checkout — FloraFetch')

@section('content')

<h1 class="text-2xl font-bold text-gray-800 mb-6">Checkout & COD Details</h1>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    {{-- Order Summary --}}
    <div>
        <h2 class="font-bold text-gray-700 mb-3">Green Cart Items ({{ count($cart) }})</h2>
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="text-left px-4 py-3">Item</th>
                        <th class="text-center px-4 py-3">Qty</th>
                        <th class="text-right px-4 py-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($cart as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">{{ $item['name'] }}</p>
                                <p class="text-gray-400 text-xs">PKR {{ number_format($item['price'], 0) }} each</p>
                            </td>
                            <td class="text-center px-4 py-3 text-gray-600">{{ $item['quantity'] }}</td>
                            <td class="text-right px-4 py-3 font-semibold">PKR {{ number_format($item['price'] * $item['quantity'], 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-flora-50 border-t border-gray-100">
                    <tr>
                        <td colspan="2" class="px-4 py-3 font-bold text-gray-800">Green Total</td>
                        <td class="px-4 py-3 font-bold text-flora-700 text-right">PKR {{ number_format($total, 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- COD Delivery Form --}}
    <div>
        <h2 class="font-bold text-gray-700 mb-3">Delivery Details & COD</h2>
        <form method="POST" action="{{ route('orders.store') }}" class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="03xx-xxxxxxx"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Delivery Address</label>
                <textarea name="address" required rows="2" placeholder="House #, Street, Area"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none resize-none">{{ old('address') }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Province</label>
                    <input type="text" name="province" value="{{ old('province') }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Postal Code</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-flora-50 border border-flora-100 rounded-xl p-4">
                <p class="text-xs font-bold text-flora-800 mb-2">Payment Method</p>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio" name="payment" value="cod" checked class="accent-flora-600">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">💵 Cash on Delivery (COD)</p>
                        <p class="text-xs text-gray-500">Pay securely upon delivery of your live plants</p>
                    </div>
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-flora-600 text-white py-3 rounded-xl font-bold text-base hover:bg-flora-700 transition">
                🌿 Place Order (COD) — PKR {{ number_format($total, 0) }}
            </button>
        </form>
    </div>

</div>

@endsection
