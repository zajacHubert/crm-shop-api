<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

interface ProductRepositoryInterface
{
    public function index(Request $request);
    public function show(string $id);
    public function store(ProductStoreRequest $request);
    public function update(ProductUpdateRequest $request);
    public function destroy(string $id);
}
