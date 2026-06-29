<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPlantController extends Controller
{
    public function index(Request $request)
    {
        $query = Plant::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $plants     = $query->orderBy('name')->paginate(15);
        $categories = Plant::distinct()->pluck('category')->sort()->values();

        return view('admin.plants.index', compact('plants', 'categories'));
    }

    public function create()
    {
        return view('admin.plants.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePlant($request);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('plants', 'public');
        }

        Plant::create($validated);

        return redirect()->route('admin.plants.index')
            ->with('success', 'Plant "' . $validated['name'] . '" added to inventory.');
    }

    public function edit(Plant $plant)
    {
        return view('admin.plants.edit', compact('plant'));
    }

    public function update(Request $request, Plant $plant)
    {
        $validated = $this->validatePlant($request);

        if ($request->hasFile('image')) {
            if ($plant->image_url) {
                Storage::disk('public')->delete($plant->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('plants', 'public');
        }

        $plant->update($validated);

        return redirect()->route('admin.plants.index')
            ->with('success', 'Plant "' . $plant->name . '" updated.');
    }

    public function destroy(Plant $plant)
    {
        if ($plant->image_url) {
            Storage::disk('public')->delete($plant->image_url);
        }

        $plant->delete();

        return back()->with('success', 'Plant deleted from inventory.');
    }

    private function validatePlant(Request $request): array
    {
        return $request->validate([
            'name'                 => 'required|string|max:150',
            'category'             => 'required|string|max:80',
            'price'                => 'required|numeric|min:0',
            'sunlight_requirement' => 'required|string|max:80',
            'watering_need'        => 'required|string|max:80',
            'stock_quantity'       => 'required|integer|min:0',
            'description'          => 'nullable|string',
            'image'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    }
}
