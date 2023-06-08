<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private User $userModel)
    {
    }

    public function index(): LengthAwarePaginator
    {
        $users = $this->userModel::with(['role', 'orders'])
            ->paginate(10);

        return $users;
    }

    public function show(string $id): ?User
    {
        $user = $this->userModel::with(['role', 'orders'])
            ->where('id', $id)
            ->first();

        return $user;
    }
}
