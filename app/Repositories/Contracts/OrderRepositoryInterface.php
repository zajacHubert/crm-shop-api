<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function index(Request $request): Collection;
    public function show(string $id): ?Order;
    public function store(OrderStoreRequest $request);
    public function update(OrderUpdateRequest $request);
    public function destroy(string $id);
}
