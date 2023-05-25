<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

interface ProductServiceInterface
{
    public function store(ProductStoreRequest $request): Model;
    public function update(ProductUpdateRequest $request): Model;
    public function destroy(string $id): array;
}
