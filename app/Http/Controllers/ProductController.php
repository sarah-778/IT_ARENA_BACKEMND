<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::orderBy('created_at', 'desc')->get(), 200);
    }

    public function store(Request $request)
    {
        // 1. Validate based on your Product Model's $fillable fields
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string',
            'brand'       => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'description' => 'nullable|string',
            'isOEM'       => 'nullable|boolean',
            'warranty'    => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
        ]);

        // 2. Handle Image Upload
        if ($request->hasFile('image')) {
            // Stores in storage/app/public/products
            $path = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $path;
        }

        // 3. Create the product
        $product = Product::create($validatedData);

        return response()->json($product, 201);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Delete image file from storage if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return response()->json(['message' => 'Asset removed from inventory'], 200);
    }
}