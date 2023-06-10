<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserRegisterRequest;

class UserController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository, private UserServiceInterface $userService)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        return $this->userRepository->index($request);
    }

    public function show(string $id): ?User
    {
        return $this->userRepository->show($id);
    }

    public function register(UserRegisterRequest $request): User
    {
        return $this->userService->register($request);
    }

    public function login(UserLoginRequest $request): Response
    {
        return $this->userService->login($request);
    }

    public function refreshAuth(Request $request): Response
    {
        return $this->userService->refreshAuth($request);
    }

    public function logout(): Response
    {
        return $this->userService->logout();
    }

    public function update(UserUpdateRequest $request): Model
    {
        return $this->userService->update($request);
    }

    public function destroy(string $id): array
    {
        return $this->userService->destroy($id);
    }
}
