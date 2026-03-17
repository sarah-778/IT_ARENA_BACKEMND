<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        // Fetch all products, ordered by newest first
        return response()->json(Product::orderBy('created_at', 'desc')->get(), 200);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
{
    // Validate incoming data
    $request->validate([
        'customer_name' => 'required|string',
        'phone'         => 'required|string',
        'email'         => 'required|email',
        'district'      => 'required|string',
        'address'       => 'required|string',
        'items'         => 'required|array',
        'subtotal'      => 'required|numeric',
    ]);

    // CALCULATE MISSING FIELDS
    $delivery_fee = ($request->district === "Kampala") ? 10000 : 20000;
    $total = $request->subtotal + $delivery_fee;
    
    // GENERATE UNIQUE ORDER NUMBER
    $order_number = 'ITA-' . strtoupper(bin2hex(random_bytes(3)));

    // SAVE TO DATABASE
    $order = \App\Models\Order::create([
        'order_number'  => $order_number,
        'customer_name' => $request->customer_name,
        'phone'         => $request->phone,
        'email'         => $request->email,
        'district'      => $request->district,
        'address'       => $request->address,
        'items'         => $request->items,
        'subtotal'      => $request->subtotal,
        'delivery_fee'  => $delivery_fee,
        'total'         => $total,
        'status'        => 'pending',
    ]);

    return response()->json(['order' => $order], 201);
}
    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Asset removed from inventory'], 200);
    }
}