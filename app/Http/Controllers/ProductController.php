<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        return $products;
    }

    public function show(Request $request)
    {
        $product = Product::find($request->id);

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

    public function destroy(Request $request)
    {
        $success = Product::destroy($request['id']);
        return [
            'success' => boolval($success),
        ];
    }
}
