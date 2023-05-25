<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function index(Request $request): Collection;
    public function show(string $id): Model;
}
