<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'products'])->paginate(10);

        return $orders;
    }

    public function show(Request $request)
    {
        $order = Order::with(['user', 'products'])
            ->where('id', [$request['id']])
            ->first();

        return $order;
    }

    public function store(Request $request)
    {
        $order = new Order();
        $order->id = Str::uuid()->toString();
        $order->user_id = $request['user_id'];
        $order->created_at = Carbon::now();
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
        return ['success' => true];
    }

    public function update(Request $request)
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

    public function destroy(Request $request)
    {
        $success = Order::destroy($request['id']);
        return [
            'success' => boolval($success),
        ];
    }
}
