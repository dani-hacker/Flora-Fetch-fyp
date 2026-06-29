@extends('layouts.app')
@section('title', 'My Orders — FloraFetch')
@section('content')

<h1 class="text-2xl font-bold text-gray-800 mb-6">📦 My Orders</h1>

@if($orders->isEmpty())
    <div class="text-center py-16 text-gray-400">
        <p class="text-6xl mb-4">🌱</p>
        <p class="text-lg font-medium">No orders yet</p>
        <a href="{{ route('plants.index') }}"
           class="mt-4 inline-block bg-flora-600 text-white px-6 py-2 rounded-xl font-medium hover:bg-flora-700 transition">
            Browse Plants
        </a>
    </div>
@else
    <div class="space-y-4">
        @foreach($orders as $order)
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">

                {{-- Order header --}}
                <div class="px-5 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="font-mono text-sm font-bold text-gray-700">
                            Order #FF-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Placed on {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div class="text-right">
                        @php
                            $badge = match($order->status) {
                                'Pending'    => 'bg-yellow-100 text-yellow-700',
                                'Processing' => 'bg-blue-100 text-blue-700',
                                'Delivered'  => 'bg-flora-100 text-flora-700',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badge }}">
                            {{ $order->status }}
                        </span>
                        <p class="text-sm font-bold text-gray-800 mt-1">
                            PKR {{ number_format($order->total_amount, 0) }}
                        </p>
                    </div>
                </div>

                {{-- Order items --}}
                <div class="px-5 py-4">
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">🌿</span>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $item->plant->name ?? 'Plant' }}</p>
                                        <p class="text-xs text-gray-400">Qty: {{ $item->quantity }} × PKR {{ number_format($item->price_at_purchase, 0) }}</p>
                                    </div>
                                </div>
                                <p class="font-semibold text-gray-700">
                                    PKR {{ number_format($item->line_total, 0) }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Shipping address --}}
                    <div class="mt-3 pt-3 border-t border-gray-50">
                        <p class="text-xs text-gray-400">📍 Delivery to: <span class="text-gray-600">{{ $order->shipping_address }}</span></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
@endif

@endsection
