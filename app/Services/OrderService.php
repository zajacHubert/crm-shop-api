<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;

class OrderService implements OrderServiceInterface
{
    public function __construct(private OrderRepositoryInterface $orderRepository)
    {
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
        $order = $this->orderRepository->show($request['id']);

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
