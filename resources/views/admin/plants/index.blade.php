{{-- resources/views/admin/plants/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Manage Inventory — Admin')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">🌿 Plant Inventory</h1>
    <a href="{{ route('admin.plants.create') }}"
       class="bg-flora-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-flora-700 transition">
        + Add New Plant
    </a>
</div>

{{-- Search/filter bar --}}
<form method="GET" action="{{ route('admin.plants.index') }}" class="flex gap-3 mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search plants..."
           class="border border-gray-200 rounded-lg px-3 py-2 text-sm flex-1 focus:outline-none focus:ring-2 focus:ring-flora-500">
    <select name="category" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    <button class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition">Search</button>
</form>

<div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Plant</th>
                <th class="text-left px-5 py-3">Category</th>
                <th class="text-left px-5 py-3">Price</th>
                <th class="text-left px-5 py-3">Sunlight</th>
                <th class="text-left px-5 py-3">Watering</th>
                <th class="text-center px-5 py-3">Stock</th>
                <th class="text-center px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($plants as $plant)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3 font-medium text-gray-800">{{ $plant->name }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $plant->category }}</td>
                    <td class="px-5 py-3 font-semibold text-flora-700">PKR {{ number_format($plant->price, 0) }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $plant->sunlight_requirement }}</td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $plant->watering_need }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $plant->stock_quantity < 5 ? 'bg-red-100 text-red-700' : 'bg-flora-100 text-flora-700' }}">
                            {{ $plant->stock_quantity }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <div class="flex gap-2 justify-center">
                            <a href="{{ route('admin.plants.edit', $plant) }}"
                               class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-lg hover:bg-blue-100 transition">Edit</a>
                            <form method="POST" action="{{ route('admin.plants.destroy', $plant) }}"
                                  onsubmit="return confirm('Delete {{ $plant->name }}?')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-50 text-red-600 px-3 py-1 rounded-lg hover:bg-red-100 transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-8 text-gray-400">No plants in inventory.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $plants->withQueryString()->links() }}</div>
@endsection
