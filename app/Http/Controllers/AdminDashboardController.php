<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plant;
use App\Models\User;

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
