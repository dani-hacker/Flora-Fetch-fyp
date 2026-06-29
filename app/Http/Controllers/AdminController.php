<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// ═══════════════════════════════════════════════════════════════════════════════
// AdminDashboardController
// ═══════════════════════════════════════════════════════════════════════════════
class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders_today' => Order::whereDate('created_at', today())->count(),
            'pending_orders'     => Order::where('status', 'Pending')->count(),
            'total_plants'       => Plant::count(),
            'low_stock_alerts'   => Plant::where('stock_quantity', '<', 5)->count(),
            'total_users'        => User::where('role', 'customer')->count(),
        ];

        $recentOrders = Order::with('user', 'items.plant')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}

// ═══════════════════════════════════════════════════════════════════════════════
// AdminPlantController — Full CRUD for plant inventory
// ═══════════════════════════════════════════════════════════════════════════════
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
            // Remove old image if exists
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

// ═══════════════════════════════════════════════════════════════════════════════
// AdminOrderController — View and update order status
// ═══════════════════════════════════════════════════════════════════════════════
class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update delivery status — FR-05 (Order Tracking).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Delivered',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order #' . $order->id . ' status updated to ' . $request->status . '.');
    }
}
