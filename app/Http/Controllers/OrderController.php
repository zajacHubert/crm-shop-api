<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    protected $order_repository;

    public function __construct(OrderRepositoryInterface $order_repository)
    {
        $this->order_repository = $order_repository;
    }

    public function index(Request $request)
    {
        return $this->order_repository->index($request);
    }

    public function show(string $id)
    {
        return $this->order_repository->show($id);
    }

    public function store(OrderStoreRequest $request)
    {
        return $this->order_repository->store($request);
    }

    public function update(OrderUpdateRequest $request)
    {
        return $this->order_repository->update($request);
    }

    public function destroy(string $id)
    {
        return $this->order_repository->destroy($id);
    }
}
