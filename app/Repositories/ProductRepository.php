<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    public function index(Request $request): Collection
    {
        if ($request['product_category']) {
            $products = Product::where('product_category', $request['product_category'])->paginate(10);
        } else {
            $products = Product::paginate(10);
        }

        return $products;
    }

    public function show(string $id): Model
    {
        $product = Product::find($id);

        return $product;
    }
}
