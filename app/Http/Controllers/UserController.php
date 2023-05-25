<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository, private UserServiceInterface $userService)
    {
    }

    public function index()
    {
        return $this->userRepository->index();
    }

    public function show(string $id)
    {
        return $this->userRepository->show($id);
    }

    public function register(UserRegisterRequest $request)
    {
        return $this->userService->register($request);
    }

    public function login(UserLoginRequest $request)
    {
        return $this->userService->login($request);
    }

    public function refreshAuth(Request $request)
    {
        return $this->userService->refreshAuth($request);
    }

    public function logout()
    {
        return $this->userService->logout();
    }

    public function update(UserUpdateRequest $request)
    {
        return $this->userService->update($request);
    }

    public function destroy(string $id)
    {
        return $this->userService->destroy($id);
    }
}
