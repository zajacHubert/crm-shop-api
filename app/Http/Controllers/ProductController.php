<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductController extends Controller
{
    public function __construct(private ProductRepositoryInterface $productRepository, private ProductServiceInterface $productService)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        return $this->productRepository->index($request);
    }

    public function show(string $id): ?Product
    {
        return $this->productRepository->show($id);
    }

    public function store(ProductStoreRequest $request): Model
    {
        return $this->productService->store($request);
    }

    public function update(ProductUpdateRequest $request): Model
    {
        return $this->productService->update($request);
    }

    public function destroy(string $id): array
    {
        return $this->productService->destroy($id);
    }
}
