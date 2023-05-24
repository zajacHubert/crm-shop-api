<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function index();
    public function show(string $id);
    public function register(UserRegisterRequest $request);
    public function login(UserLoginRequest $request);
    public function refreshAuth(Request $request);
    public function logout();
    public function update(UserUpdateRequest $request);
    public function destroy(string $id);
}
