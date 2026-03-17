<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for the Admin Dashboard.
     */
    public function index()
    {
        return response()->json(Order::orderBy('created_at', 'desc')->get(), 200);
    }

    /**
     * Store a newly created order (Checkout).
     */
    public function store(Request $request)
{
    // 1. Validate the basic info from React
    $request->validate([
        'customer_name' => 'required|string',
        'phone'         => 'required|string',
        'district'      => 'required|string',
        'address'       => 'required|string',
        'items'         => 'required|array',
        'subtotal'      => 'required|numeric',
    ]);

    // 2. Generate the data the migration requires
    $delivery_fee = ($request->district === 'Kampala') ? 10000 : 20000;
    $total = $request->subtotal + $delivery_fee;
    
    // Create a unique number like ITA-8F2B
    $order_number = 'ITA-' . strtoupper(substr(uniqid(), -4));

    // 3. Create the order
    $order = \App\Models\Order::create([
        'order_number'  => $order_number,
        'customer_name' => $request->customer_name,
        'phone'         => $request->phone,
        'email'         => $request->email ?? 'no-email@itarena.com', // Default if empty
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
     * Update order status (Admin only).
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate(['status' => 'required|in:pending,processing,delivered,cancelled']);
            
            $order = Order::findOrFail($id);
            $order->update(['status' => $request->status]);

            return response()->json(['message' => 'Order status updated', 'order' => $order], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Update failed'], 500);
        }
    }

    /**
     * Delete an order record.
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->delete();
        return response()->json(['message' => 'Order removed from records'], 200);
    }
}