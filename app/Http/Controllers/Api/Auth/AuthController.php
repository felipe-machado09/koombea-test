<?php

namespace App\Http\Controllers\Api\Auth;

use DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth as Authenticated;

class AuthController extends Controller
{
    private $loggedUser;
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->loggedUser = Authenticated::guard('sanctum')->user();
    }

    public function register(Request $request)
    {
        return $this->authService->register($request);
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function logout()
    {
        return $this->authService->logout();
    }
}
