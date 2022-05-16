<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $isAttempt = $this->authService->attempt($request->validated());

        if (!$isAttempt) {
            return $this->errorResponse(['errors' => 'Unauthorised'], 'Unauthorised', 401);
        }

        $user = User::with('contact:id,first_name,last_name,middle_name')->find(Auth::id());

        $response = [
            'token' => $user->createToken($user->username)->plainTextToken,
        ];

        return $this->successResponse($response, 'Login Successful');
    }
}
