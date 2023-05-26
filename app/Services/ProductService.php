<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductService implements ProductServiceInterface
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function store(ProductStoreRequest $request): Model
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

    public function update(ProductUpdateRequest $request): Model
    {
        $product =  $this->productRepository->show($request['id']);

        $product->product_name = $request['product_name'] ?? $product['product_name'];
        $product->product_desc = $request['product_desc'] ?? $product['product_desc'];
        $product->product_price = $request['product_price'] ?? $product['product_price'];
        $product->product_category = $request['product_category'] ?? $product['product_category'];

        $product->save();
        return $product;
    }

    public function destroy(string $id): array
    {
        $success = Product::destroy($id);
        return [
            'id' => $id,
            'success' => boolval($success),
        ];
    }
}
