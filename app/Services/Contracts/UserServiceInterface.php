<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

interface UserServiceInterface
{
    public function register(UserRegisterRequest $request): User;
    public function login(UserLoginRequest $request): Response;
    public function refreshAuth(Request $request): Response;
    public function logout(): Response;
    public function update(UserUpdateRequest $request): Model;
    public function destroy(string $id): array;
}
