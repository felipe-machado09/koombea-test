<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthRepositoryEloquent implements AuthRepositoryInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        $login = [];
        $login['email'] = $request['email'];
        $login['password'] = $request['password'];

        if (!Auth::attempt($login)) {
            return false;
        }

        return auth()->user()->createToken('API Token')->plainTextToken;
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'password' => bcrypt($request['password']),
            'email' => $request['email']
        ]);

        return $user->createToken('API Token')->plainTextToken;

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return true;
    }

}
