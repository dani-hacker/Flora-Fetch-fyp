<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Place a new order (COD).
     * Wrapped in a DB transaction — NFR-03 (data integrity).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'       => 'required|string|max:100',
            'phone'           => 'required|string|max:20',
            'address'         => 'required|string',
            'city'            => 'required|string|max:80',
            'province'        => 'required|string|max:80',
            'postal_code'     => 'required|string|max:20',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        DB::transaction(function () use ($validated, $cart) {
            // Build shipping address string
            $shippingAddress = implode(', ', [
                $validated['full_name'],
                $validated['phone'],
                $validated['address'],
                $validated['city'],
                $validated['province'],
                $validated['postal_code'],
            ]);

            // Calculate total
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            // Create the Order record
            $order = Order::create([
                'user_id'          => Auth::id(),
                'total_amount'     => $total,
                'status'           => 'Pending',
                'shipping_address' => $shippingAddress,
            ]);

            // Create Order_Items and decrement stock
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'          => $order->id,
                    'plant_id'          => $item['plant_id'],
                    'quantity'          => $item['quantity'],
                    'price_at_purchase' => $item['price'], // locked price
                ]);

                // Decrement stock
                Plant::where('id', $item['plant_id'])
                    ->decrement('stock_quantity', $item['quantity']);
            }

            // Clear the cart
            session()->forget('cart');
        });

        return redirect()->route('orders.index')
            ->with('success', 'Your order has been placed! We will deliver it Cash on Delivery.');
    }

    /**
     * Customer order history.
     */
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('items.plant')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Single order detail view.
     */
    public function show(Order $order)
    {
        // Customers can only see their own orders
        abort_unless($order->user_id === Auth::id() || Auth::user()->isAdmin(), 403);

        $order->load('items.plant');

        return view('orders.show', compact('order'));
    }
}
