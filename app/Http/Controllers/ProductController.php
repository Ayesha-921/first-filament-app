<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function home()
    {
        $featured   = Product::with(['brand', 'category'])->where('is_active', true)->where('is_featured', true)->latest()->take(8)->get();
        $latest     = Product::with(['brand', 'category'])->where('is_active', true)->latest()->take(12)->get();
        $categories = Category::where('type', 'shop')->where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->take(8)->get();

        return view('store.home', compact('featured', 'latest', 'categories', 'brands'));
    }

    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category'])->where('is_active', true);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('name', 'like', "%{$q}%");
        }
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $sort = $request->get('sort', 'latest');
        match($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name'       => $query->orderBy('name', 'asc'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(20)->withQueryString();
        $categories = Category::where('type', 'shop')->where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();

        return view('store.products', compact('products', 'categories', 'brands'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['brand', 'category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = Product::with(['brand'])
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->take(6)->get();

        return view('store.show', compact('product', 'related'));
    }

    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 1) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where('name', 'like', "%{$q}%")
            ->take(8)
            ->get(['id', 'name', 'slug', 'price', 'images', 'image']);

        $results = $products->map(function ($p) {
            $imgs  = collect($p->images ?? [])->filter()->values();
            $first = $imgs->first() ?? $p->image;
            return [
                'name'  => $p->name,
                'slug'  => $p->slug,
                'price' => number_format($p->price, 2),
                'image' => $first ? Storage::url($first) : null,
                'url'   => '/products/' . $p->slug,
            ];
        });

        return response()->json($results->values());
    }
}
