<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $isAttempt = $this->authService->attempt($request->validated());

        if (!$isAttempt) {
            return $this->errorResponse(['errors' => 'Unauthorised'], 'Unauthorised', 401);
        }

        $user = User::with('contact:id,user_id,first_name,last_name,middle_name')->find(Auth::id());

        $response = [
            'token' => $user->createToken($user->username)->plainTextToken,
            'user' => $user
        ];

        return $this->successResponse($response, 'Login Successful');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse([], 'Logout Successful');
    }
}
