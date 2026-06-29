@extends('layouts.app')
@section('title', isset($plant) ? 'Edit Plant' : 'Add Plant')
@section('content')

<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        {{ isset($plant) ? '✏️ Edit: ' . $plant->name : '🌱 Add New Plant' }}
    </h1>

    <form method="POST"
          action="{{ isset($plant) ? route('admin.plants.update', $plant) : route('admin.plants.store') }}"
          enctype="multipart/form-data"
          class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 space-y-5">
        @csrf
        @if(isset($plant)) @method('PUT') @endif

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plant Name *</label>
                <input type="text" name="name" value="{{ old('name', $plant->name ?? '') }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select name="category" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                    @foreach(['Indoor', 'Outdoor', 'Succulents', 'Herbs'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $plant->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (PKR) *</label>
                <input type="number" name="price" value="{{ old('price', $plant->price ?? '') }}" step="0.01" min="0" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity *</label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $plant->stock_quantity ?? 0) }}" min="0" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">☀️ Sunlight Requirement *</label>
                <select name="sunlight_requirement" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                    @foreach(['Full Sun', 'Partial Shade', 'Bright Indirect Light', 'Low Light', 'Low to Bright Indirect'] as $opt)
                        <option value="{{ $opt }}" {{ old('sunlight_requirement', $plant->sunlight_requirement ?? '') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">💧 Watering Need *</label>
                <select name="watering_need" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none">
                    @foreach(['Low', 'Moderate', 'High'] as $opt)
                        <option value="{{ $opt }}" {{ old('watering_need', $plant->watering_need ?? '') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-flora-500 focus:outline-none resize-none">{{ old('description', $plant->description ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Plant Image</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none">
            @if(isset($plant) && $plant->image_url)
                <p class="text-xs text-gray-500 mt-1">Current: {{ $plant->image_url }} (upload new to replace)</p>
            @endif
            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="flex-1 bg-flora-600 text-white py-3 rounded-xl font-semibold hover:bg-flora-700 transition">
                {{ isset($plant) ? '💾 Save Changes' : '🌱 Add Plant' }}
            </button>
            <a href="{{ route('admin.plants.index') }}"
               class="flex-1 text-center border border-gray-200 text-gray-600 py-3 rounded-xl font-medium hover:bg-gray-50 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection
