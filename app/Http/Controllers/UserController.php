<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Order;
use Illuminate\Database\Eloquent\Casts\Json;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'orders'])
            ->paginate(10);

        return $users;
    }

    public function show(Request $request)
    {

        $user = User::with(['role', 'orders'])
            ->where('id', $request->id)
            ->first();

        return $user;
    }

    public function register(UserRegisterRequest $request)
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

    public function login(UserLoginRequest $request)
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

    public function refreshAuth(Request $request)
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

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'success' => true,
            'message' => 'logged out',
        ])->withCookie($cookie);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = User::find($request['id']);

        $user->name = $request['name'] ?? $user['name'];
        $user->email = $request['email'] ?? $user['email'];
        $user->password = $request['password'] ?? $user['password'];

        $user->save();
        return $user;
    }

    public function destroy(Request $request)
    {
        $success = User::destroy($request['id']);
        return [
            'success' => boolval($success),
            'user_id' => $request['id'],
        ];
    }
}
