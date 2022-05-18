<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function getUser(Request $request): JsonResponse
    {
        $user = $this->userService->getUserData($request->user()->id);

        return $this->successResponse($user);
    }
}
