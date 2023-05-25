<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function index(Request $request): LengthAwarePaginator;
    public function show(string $id): ?Product;
}
