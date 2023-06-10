<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private User $userModel)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        if ($request['sort_param']) {
            $users = $this->userModel::with(['role', 'orders'])
                ->orderBy($request['sort_param'], $request['direction'])
                ->paginate(10);

            return $users;
        } else {
            $users = $this->userModel::with(['role', 'orders'])
                ->paginate(10);

            return $users;
        }
    }

    public function show(string $id): ?User
    {
        $user = $this->userModel::with(['role', 'orders'])
            ->where('id', $id)
            ->first();

        return $user;
    }
}
