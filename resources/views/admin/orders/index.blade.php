@extends('layouts.app')
@section('title', 'Manage Orders — Admin')
@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📦 All Orders</h1>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-flora-600 hover:underline">← Back to Dashboard</a>
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-3 mb-4">
    <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none">
        <option value="">All Statuses</option>
        <option value="Pending"    {{ request('status') === 'Pending'    ? 'selected' : '' }}>Pending</option>
        <option value="Processing" {{ request('status') === 'Processing' ? 'selected' : '' }}>Processing</option>
        <option value="Delivered"  {{ request('status') === 'Delivered'  ? 'selected' : '' }}>Delivered</option>
    </select>
    <input type="date" name="date" value="{{ request('date') }}"
           class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none">
    <button class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition">Filter</button>
    @if(request()->hasAny(['status','date']))
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-400 self-center hover:text-red-500">✕ Clear</a>
    @endif
</form>

<div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Order ID</th>
                <th class="text-left px-5 py-3">Customer</th>
                <th class="text-left px-5 py-3">Shipping Address</th>
                <th class="text-left px-5 py-3">Date</th>
                <th class="text-center px-5 py-3">Status</th>
                <th class="text-right px-5 py-3">Total</th>
                <th class="text-center px-5 py-3">Update Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3 font-mono text-xs text-gray-600 font-bold">
                        FF-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs max-w-xs truncate">
                        {{ $order->shipping_address }}
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">
                        {{ $order->created_at->format('d M Y') }}<br>
                        <span class="text-gray-400">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        @php
                            $badge = match($order->status) {
                                'Pending'    => 'bg-yellow-100 text-yellow-700',
                                'Processing' => 'bg-blue-100 text-blue-700',
                                'Delivered'  => 'bg-flora-100 text-flora-700',
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right font-bold text-gray-800">
                        PKR {{ number_format($order->total_amount, 0) }}
                    </td>
                    <td class="px-5 py-3 text-center">
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-flora-500">
                                <option value="Pending"    {{ $order->status === 'Pending'    ? 'selected' : '' }}>Pending</option>
                                <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Delivered"  {{ $order->status === 'Delivered'  ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-10 text-gray-400">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $orders->withQueryString()->links() }}</div>

@endsection
