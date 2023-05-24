<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Repositories\OrderRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderServiceInterface $orderService
    ) {
    }

    public function index(Request $request)
    {
        return $this->orderRepository->index($request);
    }

    public function show(string $id)
    {
        return $this->orderRepository->show($id);
    }

    public function store(OrderStoreRequest $request)
    {
        return $this->orderService->store($request);
    }

    public function update(OrderUpdateRequest $request)
    {
        return $this->orderService->update($request);
    }

    public function destroy(string $id)
    {
        return $this->orderService->destroy($id);
    }
}
