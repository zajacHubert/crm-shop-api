<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private Product $productModel)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        if ($request['product_category'] && !$request['sort_param']) {
            $products = $this->productModel::where('product_category', $request['product_category'])
                ->paginate(10);
        } else if (!$request['product_category'] && $request['sort_param']) {
            $products = $this->productModel::orderBy($request['sort_param'], $request['direction'])
                ->paginate(10);
        } else if ($request['product_category'] && $request['sort_param']) {
            $products = $this->productModel::where('product_category', $request['product_category'])
                ->orderBy($request['sort_param'], $request['direction'])
                ->paginate(10);
        } else {
            $products = $this->productModel::paginate(10);
        }

        return $products;
    }

    public function show(string $id): ?Product
    {
        $product = $this->productModel::find($id);
        return $product;
    }
}
