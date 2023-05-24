<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;

interface OrderServiceInterface
{
    public function store(OrderStoreRequest $request): array;
    public function update(OrderUpdateRequest $request): Model;
    public function destroy(string $id): array;
}
