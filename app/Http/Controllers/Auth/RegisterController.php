<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'unique:users,username'],
            'first_name' => ['required'],
            'last_name' => ['sometimes'],
            'middle_name' => ['sometimes'],
            'email' => ['required', 'unique:users,email'],
            'age' => ['sometimes', 'int'],
            'password' => ['required', 'min:4'],
            'password_confirm' => ['required', 'same:password'],
            'organisation_id' => ['sometimes', 'int', 'exists:organisations,id']
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->getMessages(), $validator->getMessageBag()->all(), 400);
        }

        DB::beginTransaction();
        try {
            $this->authService->register($validator->validated());

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->errorResponse([], $exception->getMessage(), 400);
        }

        return $this->successResponse([], 'User created', 201);
    }

    public function approveEmail(Request $request)
    {
        $isApproved = User::query()->where('id', Crypt::decrypt($request->userId))->update([
            'email_verified_at' => now()
        ]);

        return $isApproved
            ? redirect('/')->with('email_approve', 'Email approved')
            : redirect('/')->with('email_approve', 'Email not approved');

    }
}
