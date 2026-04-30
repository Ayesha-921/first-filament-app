<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products — MyShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f3f3; }
        .star { color: #e77600; }
        .card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-cart { background: #ffd814; border: 1px solid #c7a200; }
        .btn-cart:hover { background: #f7ca00; }
    </style>
</head>
<body class="bg-gray-100">

    {{-- Nav --}}
    <nav class="bg-gray-900 text-white px-4 py-2 flex items-center gap-4">
        <a href="{{ route('products.index') }}" class="text-xl font-bold text-white hover:text-yellow-400">
            🛒 YourShop
        </a>
        <div class="flex-1 flex">
            <input type="text" placeholder="Search products..."
                class="flex-1 px-3 py-2 text-black rounded-l text-sm outline-none" />
            <button class="bg-yellow-400 px-4 py-2 rounded-r text-black font-bold text-sm hover:bg-yellow-500">
                🔍
            </button>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">All Products</h1>

        @if($products->isEmpty())
            <div class="text-center py-20 text-gray-500">
                <div class="text-6xl mb-4">📦</div>
                <p class="text-xl">No products found.</p>
                <a href="/admin/products/create" class="text-blue-600 hover:underline text-sm mt-2 block">Add a product in Admin →</a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($products as $product)
                    @php
                        $images = collect($product->images ?? [])
                            ->filter()
                            ->map(fn($img) => \Illuminate\Support\Facades\Storage::url($img))
                            ->values();
                        $thumb = $images->first()
                            ?? ($product->image ? \Illuminate\Support\Facades\Storage::url($product->image) : null);
                    @endphp
                    <a href="{{ route('products.show', $product->slug) }}"
                        class="card bg-white rounded shadow p-3 flex flex-col hover:shadow-lg transition-shadow duration-200">
                        {{-- Image --}}
                        <div class="h-44 flex items-center justify-center mb-2 overflow-hidden rounded">
                            @if($thumb)
                                <img src="{{ $thumb }}" alt="{{ $product->name }}"
                                    class="max-h-full max-w-full object-contain" />
                            @else
                                <div class="text-5xl text-gray-300">📦</div>
                            @endif
                        </div>

                        {{-- Name --}}
                        <p class="text-sm text-gray-900 font-medium leading-tight mb-1 line-clamp-2"
                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $product->name }}
                        </p>

                        {{-- Brand --}}
                        @if($product->brand)
                            <p class="text-xs text-blue-600 mb-1">{{ $product->brand->name }}</p>
                        @endif

                        {{-- Stars --}}
                        <div class="star text-sm mb-1">★★★★☆</div>

                        {{-- Price --}}
                        <p class="text-base font-bold text-gray-900 mt-auto">
                            ${{ number_format($product->price, 2) }}
                        </p>

                        {{-- Stock --}}
                        @if($product->stock > 0)
                            <p class="text-xs text-green-700 mt-0.5">In Stock</p>
                        @else
                            <p class="text-xs text-red-600 mt-0.5">Out of Stock</p>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</body>
</html>
