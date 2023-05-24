<?php

declare(strict_types=1);

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class OrderRepository implements OrderRepositoryInterface
{
    public function index(Request $request): Collection
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

    public function store(OrderStoreRequest $request): array
    {
        $order = new Order();
        $order->id = Str::uuid()->toString();
        $order->user_id = $request['user_id'];
        $order->created_at = Carbon::now();
        $order->value = $request['value'];
        $order->save();

        $order_product_data = [];
        foreach ($request['productsIds'] as $productId) {
            array_push($order_product_data, (object)[
                'id' => Str::uuid()->toString(),
                'order_id' => $order->id,
                'product_id' => $productId,
            ]);
        }

        foreach ($order_product_data as $item) {
            DB::table('order_product')->insert((array)$item);
        }
        return [
            'success' => true,
            'order_id' => $order->id,
        ];
    }

    public function update(OrderUpdateRequest $request): Model
    {
        $order = Order::find($request['id']);

        if ($request['user_id']) {
            DB::table('orders')
                ->where('id', $order->id)
                ->update(['user_id' => $request['user_id']]);
        }

        if ($request['productsIds']) {
            $order_product_data = [];

            foreach ($request['productsIds'] as $productId) {
                array_push($order_product_data, (object)[
                    'id' => Str::uuid()->toString(),
                    'order_id' => $order->id,
                    'product_id' => $productId,
                ]);
            }

            DB::table('order_product')->where('order_id', $order->id)->delete();

            foreach ($order_product_data as $item) {
                DB::table('order_product')->updateOrInsert((array)$item);
            }
        }

        $complete_order = Order::with(['user', 'products'])
            ->where('id', [$request['id']])
            ->first();

        return $complete_order;
    }

    public function destroy(string $id): array
    {
        $success = Order::destroy($id);
        return [
            'success' => boolval($success),
            'order_id' => [$id],
        ];
    }
}