<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function index(Request $request): LengthAwarePaginator
    {
        if ($request['sort_param']) {
            $orders = Order::with(['user', 'products'])
                ->orderBy($request['sort_param'], $request['direction'])
                ->paginate(10);
        } else {
            $orders = Order::with(['user', 'products'])
                ->paginate(10);
        }

        return $orders;
    }

    public function show(string $id): ?Order
    {
        $order = Order::with(['user', 'products'])
            ->where('id', $id)
            ->first();

        return $order;
    }
}
