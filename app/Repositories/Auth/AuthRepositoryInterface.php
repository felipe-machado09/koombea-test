<?php

namespace App\Repositories\Auth;

use Illuminate\Http\Request;
use stdClass;

interface AuthRepositoryInterface
{
    public function login(Request $request);
    public function register(Request $request);
    public function logout();
}
