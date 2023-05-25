<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class UserService implements UserServiceInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function register(UserRegisterRequest $request): User
    {
        $user = new User();
        $user->id = Str::uuid()->toString();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->role_id = $request['role_id'];

        $user->save();

        $user_with_role = User::with('role')
            ->where('id', $user->id)
            ->first();

        return $user_with_role;
    }

    public function login(UserLoginRequest $request): Response
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = Auth::user();

        $jwt = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $jwt, 60 * 24, null, null, null, false);

        $user = User::with('role')
            ->where('email', $request['email'] ?? '')
            ->first();

        return response([
            'jwt' => $jwt,
            'user_logged' => $user
        ])->withCookie($cookie);
    }

    public function refreshAuth(Request $request): Response
    {
        $user = Auth::user();

        $user_with_role = User::with('role')
            ->where('id', $user->id)
            ->first();

        return response([
            'jwt' => $request->bearerToken('jwt'),
            'user_logged' => $user_with_role,
        ]);
    }

    public function logout(): Response
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'success' => true,
            'message' => 'logged out',
        ])->withCookie($cookie);
    }

    public function update(UserUpdateRequest $request): Model
    {
        $user = $this->userRepository->show($request['id']);

        $user->name = $request['name'] ?? $user['name'];
        $user->email = $request['email'] ?? $user['email'];
        $user->password = $request['password'] ?? $user['password'];

        $user->save();
        return $user;
    }

    public function destroy(string $id): array
    {
        $success = User::destroy($id);
        return [
            'success' => boolval($success),
            'user_id' => $id,
        ];
    }
}
