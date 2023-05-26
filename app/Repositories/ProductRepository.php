<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function index(Request $request): LengthAwarePaginator
    {
        if ($request['product_category']) {
            $products = Product::where('product_category', $request['product_category'])->paginate(10);
        } else {
            $products = Product::paginate(10);
        }

        return $products;
    }

    public function show(string $id): ?Product
    {
        $product = Product::find($id);
        return $product;
    }
}
