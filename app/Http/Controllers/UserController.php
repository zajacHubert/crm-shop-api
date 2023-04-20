<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request)
    {
        $user = new User();
        $user->id = Str::uuid()->toString();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->role_id = $request['role_id'];

        $user->save();
        return $user;
    }

    public function update(Request $request)
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
        ];
    }
}
