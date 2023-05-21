<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user_repository;

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function index()
    {
        return $this->user_repository->index();
    }

    public function show(string $id)
    {
        return $this->user_repository->show($id);
    }

    public function register(UserRegisterRequest $request)
    {
        return $this->user_repository->register($request);
    }

    public function login(UserLoginRequest $request)
    {
        return $this->user_repository->login($request);
    }

    public function refreshAuth(Request $request)
    {
        return $this->user_repository->refreshAuth($request);
    }

    public function logout()
    {
        return $this->user_repository->logout();
    }

    public function update(UserUpdateRequest $request)
    {
        return $this->user_repository->update($request);
    }

    public function destroy(string $id)
    {
        return $this->user_repository->destroy($id);
    }
}
