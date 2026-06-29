<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Catalog page — with optional category/sunlight/watering filters.
     * Loads within NFR-01 target by using indexed columns.
     */
    public function index(Request $request)
    {
        $query = Plant::inStock();

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('sunlight')) {
            $query->bySunlight($request->sunlight);
        }

        if ($request->filled('watering')) {
            $query->byWatering($request->watering);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $plants = $query->orderBy('name')->paginate(12);

        $categories      = Plant::distinct()->pluck('category')->sort()->values();
        $sunlightOptions = Plant::distinct()->pluck('sunlight_requirement')->sort()->values();
        $wateringOptions = Plant::distinct()->pluck('watering_need')->sort()->values();

        return view('plants.index', compact(
            'plants', 'categories', 'sunlightOptions', 'wateringOptions'
        ));
    }

    /**
     * Plant detail page.
     */
    public function show(Plant $plant)
    {
        $related = Plant::byCategory($plant->category)
            ->where('id', '!=', $plant->id)
            ->inStock()
            ->limit(4)
            ->get();

        return view('plants.show', compact('plant', 'related'));
    }
}
