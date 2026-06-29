<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Cart is stored in the session as:
     * session('cart') => [ plant_id => ['plant' => [...], 'quantity' => N] ]
     */

    public function index()
    {
        $cart  = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Plant $plant)
    {
        $request->validate(['quantity' => 'integer|min:1|max:' . $plant->stock_quantity]);

        $quantity = (int) $request->input('quantity', 1);
        $cart     = session('cart', []);
        $id       = $plant->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = min(
                $cart[$id]['quantity'] + $quantity,
                $plant->stock_quantity
            );
        } else {
            $cart[$id] = [
                'plant_id' => $plant->id,
                'name'     => $plant->name,
                'price'    => $plant->price,
                'image'    => $plant->image_url,
                'quantity' => $quantity,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', $plant->name . ' added to your cart!');
    }

    public function update(Request $request, $plantId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = session('cart', []);

        if (isset($cart[$plantId])) {
            $cart[$plantId]['quantity'] = (int) $request->quantity;
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove($plantId)
    {
        $cart = session('cart', []);
        unset($cart[$plantId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }

    /**
     * Checkout page (COD form).
     */
    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.checkout', compact('cart', 'total'));
    }
}
