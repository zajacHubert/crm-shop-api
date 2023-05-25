<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function index(Request $request): LengthAwarePaginator;
    public function show(string $id): Model;
}
