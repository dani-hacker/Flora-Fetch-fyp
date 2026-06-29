@extends('layouts.app')

@section('title', 'Admin Dashboard — FloraFetch')

@section('content')

<div class="flex gap-6">

    {{-- Admin Sidebar --}}
    <aside class="w-48 shrink-0">
        <div class="bg-flora-900 text-flora-100 rounded-xl p-4 sticky top-20">
            <p class="text-xs uppercase font-bold text-flora-400 mb-4">Admin Panel</p>
            <nav class="space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-flora-800 text-white font-medium">🏠 Dashboard</a>
                <a href="{{ route('plants.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-flora-800 transition">🌿 Catalog</a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-flora-800 transition">📦 Orders</a>
                <a href="{{ route('admin.plants.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-flora-800 transition">📋 Inventory</a>
                <a href="{{ route('admin.plants.create') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-flora-800 transition">➕ Add Plant</a>
            </nav>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
            <a href="{{ route('admin.plants.index') }}"
               class="bg-flora-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-flora-700 transition">
                ✏️ Update Inventory
            </a>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-5 gap-4 mb-8">
            @foreach([
                ['label' => 'Orders Today', 'value' => $stats['total_orders_today'], 'icon' => '📦', 'color' => 'blue'],
                ['label' => 'Pending', 'value' => $stats['pending_orders'], 'icon' => '⏳', 'color' => 'yellow'],
                ['label' => 'Total Plants', 'value' => $stats['total_plants'], 'icon' => '🌿', 'color' => 'green'],
                ['label' => 'Low Stock', 'value' => $stats['low_stock_alerts'], 'icon' => '⚠️', 'color' => 'red'],
                ['label' => 'Customers', 'value' => $stats['total_users'], 'icon' => '👤', 'color' => 'purple'],
            ] as $stat)
                <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm text-center">
                    <p class="text-2xl mb-1">{{ $stat['icon'] }}</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stat['value'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Recent Orders Table --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="font-bold text-gray-700">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-xs text-flora-600 hover:underline">View All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="text-left px-5 py-3">Order ID</th>
                            <th class="text-left px-5 py-3">Customer</th>
                            <th class="text-left px-5 py-3">Items</th>
                            <th class="text-left px-5 py-3">Date</th>
                            <th class="text-left px-5 py-3">Status</th>
                            <th class="text-right px-5 py-3">Total</th>
                            <th class="text-center px-5 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3 font-mono text-xs text-gray-600">FF-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $order->user->name }}</td>
                                <td class="px-5 py-3 text-gray-500 text-xs">{{ $order->items->count() }} item(s)</td>
                                <td class="px-5 py-3 text-gray-500 text-xs">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-5 py-3">
                                    @php
                                        $badge = match($order->status) {
                                            'Pending'    => 'bg-yellow-100 text-yellow-700',
                                            'Processing' => 'bg-blue-100 text-blue-700',
                                            'Delivered'  => 'bg-flora-100 text-flora-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $order->status }}</span>
                                </td>
                                <td class="px-5 py-3 text-right font-bold text-gray-800">PKR {{ number_format($order->total_amount, 0) }}</td>
                                <td class="px-5 py-3 text-center">
                                    {{-- Quick status update --}}
                                    <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                                class="text-xs border border-gray-200 rounded-lg px-2 py-1 focus:outline-none">
                                            <option value="Pending"    {{ $order->status === 'Pending'    ? 'selected' : '' }}>Pending</option>
                                            <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="Delivered"  {{ $order->status === 'Delivered'  ? 'selected' : '' }}>Delivered</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-8 text-gray-400">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
