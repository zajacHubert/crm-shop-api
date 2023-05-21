<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Symfony\Component\HttpFoundation\Response;


class ProductRepository implements ProductRepositoryInterface
{
    public function index(Request $request)
    {
        if ($request['product_category']) {
            $products = Product::where('product_category', $request['product_category'])->paginate(10);
        } else {
            $products = Product::paginate(10);
        }

        return $products;
    }

    public function show(string $id)
    {
        $product = Product::find($id);

        return $product;
    }

    public function store(ProductStoreRequest $request)
    {
        $product = new Product();
        $product->id = Str::uuid()->toString();
        $product->product_name = $request['product_name'];
        $product->product_desc = $request['product_desc'];
        $product->product_price = $request['product_price'];
        $product->product_category = $request['product_category'];

        $product->save();
        return $product;
    }

    public function update(ProductUpdateRequest $request)
    {
        $product =  Product::find($request['id']);

        $product->product_name = $request['product_name'] ?? $product['product_name'];
        $product->product_desc = $request['product_desc'] ?? $product['product_desc'];
        $product->product_price = $request['product_price'] ?? $product['product_price'];
        $product->product_category = $request['product_category'] ?? $product['product_category'];

        $product->save();
        return $product;
    }

    public function destroy(string $id)
    {
        $success = Product::destroy($id);
        return [
            'id' => $id,
            'success' => boolval($success),
        ];
    }
}
