<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Repositories\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $product_repository;

    public function __construct(ProductRepositoryInterface $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function index(Request $request)
    {
        return $this->product_repository->index($request);
    }

    public function show(string $id)
    {
        return $this->product_repository->show($id);
    }

    public function store(ProductStoreRequest $request)
    {
        return $this->product_repository->store($request);
    }

    public function update(ProductUpdateRequest $request)
    {
        return $this->product_repository->update($request);
    }

    public function destroy(string $id)
    {
        return $this->product_repository->destroy($id);
    }
}
