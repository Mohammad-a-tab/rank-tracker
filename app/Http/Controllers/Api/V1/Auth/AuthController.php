<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\AuthLoginRequest;

class AuthController extends Controller
{
    use JsonResponseTrait;

    public function login(AuthLoginRequest $request)
    {
        $user = User::query()
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return $this->errorResponse(
                'کاربر یافت نشد',
                404
            );
        }

        if(!Hash::check($request->password, $user->password)) {
            return $this->errorResponse(
                'نام کاربری یا پسورد اشتباه است!',
                401
            );
        }

        $token = $user->createToken('API')->plainTextToken;

        return $this->successResponse(
            'ورود با موفقیت!',
            [
                'token'     => $token
            ]
        );
    }

    public function logout()
    {
        $loggedInUser = auth('sanctum')->user();

        $loggedInUser->currentAccessToken()->delete();

        return $this->successResponse('شما با موفقیت خارج شدید.');
    }
}
