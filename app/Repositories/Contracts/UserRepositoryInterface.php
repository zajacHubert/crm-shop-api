<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function index(Request $request): LengthAwarePaginator;
    public function show(string $id): ?User;
}
