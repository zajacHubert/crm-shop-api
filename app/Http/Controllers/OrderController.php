<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;

class OrderController extends Controller
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderServiceInterface $orderService
    ) {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        return $this->orderRepository->index($request);
    }

    public function show(string $id): ?Order
    {
        return $this->orderRepository->show($id);
    }

    public function store(OrderStoreRequest $request): array
    {
        return $this->orderService->store($request);
    }

    public function update(OrderUpdateRequest $request): Model
    {
        return $this->orderService->update($request);
    }

    public function destroy(string $id): array
    {
        return $this->orderService->destroy($id);
    }
}
