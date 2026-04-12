<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function products(Request $request)
    {
        $products = Product::with(['brand', 'category'])
            ->where('is_active', true)
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'user' => $request->get('auth_user')?->email ?? 'unknown',
            'count' => $products->count(),
            'products' => $products->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $p->price,
                    'brand' => $p->brand?->name,
                    'category' => $p->category?->name,
                ];
            })
        ]);
    }

    public function product(Request $request, $id)
    {
        $product = Product::with(['brand', 'category'])->find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json([
            'success' => true,
            'user' => $request->get('auth_user')?->email ?? 'unknown',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'brand' => $product->brand?->name,
                'category' => $product->category?->name,
            ]
        ]);
    }
}
