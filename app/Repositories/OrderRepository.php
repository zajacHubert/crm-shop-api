<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(private Order $orderModel)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        if ($request['sort_param'] && !$request['user_id']) {
            $orders = $this->orderModel::with(['user', 'products'])
                ->orderBy($request['sort_param'], $request['direction'])
                ->paginate(10);
        } else if (!$request['sort_param'] && $request['user_id']) {
            $orders = $this->orderModel::with(['user', 'products'])
                ->where('user_id', $request['user_id'])
                ->paginate(10);
        } else if ($request['sort_param'] && $request['user_id']) {
            $orders = $this->orderModel::with(['user', 'products'])
                ->where('user_id', $request['user_id'])
                ->orderBy($request['sort_param'], $request['direction'])
                ->paginate(10);
        } else {
            $orders = $this->orderModel::with(['user', 'products'])
                ->paginate(10);
        }

        return $orders;
    }

    public function show(string $id): ?Order
    {
        $order = $this->orderModel::with(['user', 'products'])
            ->where('id', $id)
            ->first();

        return $order;
    }
}
