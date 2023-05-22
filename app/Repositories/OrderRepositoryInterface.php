<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;

interface OrderRepositoryInterface
{
    public function index(Request $request);
    public function show(string $id);
    public function store(OrderStoreRequest $request);
    public function update(OrderUpdateRequest $request);
    public function destroy(string $id);
}
