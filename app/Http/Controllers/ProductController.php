<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;

class ProductController extends Controller
{
    private function getProductImage($product)
    {
        // Try images array first
        if (!empty($product->images) && is_array($product->images)) {
            $firstImage = collect($product->images)->filter()->first();
            if ($firstImage) {
                return Storage::url($firstImage);
            }
        }
        // Fallback to single image
        if ($product->image) {
            return Storage::url($product->image);
        }
        return null;
    }

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
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$q}%"));
            });
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

    public function cart()
    {
        $cart = session('cart', []);
        $total = 0;
        $count = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $count += $item['quantity'];
        }
        return view('store.cart', compact('cart', 'total', 'count'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $qty = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty,
                'image' => $this->getProductImage($product),
                'brand' => $product->brand ? $product->brand->name : null,
            ];
        }

        session()->put('cart', $cart);

        // Handle Buy Now redirect
        if ($request->input('redirect') === 'checkout') {
            return redirect()->route('checkout');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => array_sum(array_column($cart, 'quantity')),
                'cart' => $cart
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $qty = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            if ($qty > 0) {
                $cart[$id]['quantity'] = $qty;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('store.checkout', compact('cart', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $validated = $request->validate([
            'email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
        ]);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        session()->put('checkout_data', $validated);
        session()->put('checkout_total', $total);

        return redirect()->route('payment');
    }

    public function payment()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = session()->get('checkout_total', 0);
        $checkoutData = session()->get('checkout_data', []);

        return view('store.payment', compact('cart', 'total', 'checkoutData'));
    }

    public function stripePayment(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $checkoutData = session()->get('checkout_data', []);
        $total = session()->get('checkout_total', 0);

        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY', 'sk_test_YourStripeSecretKey'));

            $charge = Charge::create([
                'amount' => $total * 100, // Convert to cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Order from MyShop',
            ]);

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'email' => $checkoutData['email'],
                'first_name' => $checkoutData['first_name'],
                'last_name' => $checkoutData['last_name'],
                'address' => $checkoutData['address'],
                'city' => $checkoutData['city'],
                'postal_code' => $checkoutData['postal_code'],
                'phone' => $checkoutData['phone'],
                'total' => $total,
                'payment_method' => 'stripe',
                'payment_status' => 'paid',
                'status' => 'processing',
                'transaction_id' => $charge->id,
            ]);

            // Create order items
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }

            // Clear cart
            session()->forget('cart');
            session()->forget('checkout_data');
            session()->forget('checkout_total');

            return redirect()->route('order.success', $order);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function orderSuccess(Order $order)
    {
        return view('store.order-success', compact('order'));
    }

    public function orders()
    {
        if (!Auth::check()) {
            return redirect()->route('store.login')->with('error', 'Please login to view your orders.');
        }

        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('store.orders', compact('orders'));
    }

    public function newReleases()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.new-releases', compact('categories', 'brands', 'products'));
    }

    public function beauty()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.beauty', compact('categories', 'brands', 'products'));
    }

    public function azListings()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands     = Brand::where('is_active', true)->orderBy('name')->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->take(60)
                        ->get();

        return view('store.a-z-listings', compact('categories', 'brands', 'products'));
    }

    public function bestPrice()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->orderBy('price', 'asc')
                        ->take(48)
                        ->get();

        return view('store.best-price', compact('categories', 'brands', 'products'));
    }

    public function sports()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.sports', compact('categories', 'brands', 'products'));
    }

    public function fashion()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.fashion', compact('categories', 'brands', 'products'));
    }

    public function homeGarden()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.home-garden', compact('categories', 'brands', 'products'));
    }

    public function electronics()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.electronics', compact('categories', 'brands', 'products'));
    }

    public function localDeals()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.local-deals', compact('categories', 'brands', 'products'));
    }

    public function myshopResale()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.myshop-resale', compact('categories', 'brands', 'products'));
    }

    public function outlet()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.outlet', compact('categories', 'brands', 'products'));
    }

    public function renewedDeals()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(48)
                        ->get();

        return view('store.renewed-deals', compact('categories', 'brands', 'products'));
    }

    public function coupons()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $products   = Product::with(['brand', 'category'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(40)
                        ->get();

        return view('store.coupons', compact('categories', 'brands', 'products'));
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
