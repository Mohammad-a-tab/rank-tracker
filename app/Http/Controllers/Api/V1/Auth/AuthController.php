<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\V1\Auth\AuthLoginRequest;

class AuthController extends Controller
{
    use JsonResponseTrait;

    /**
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        $user = User::query()
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return $this->errorResponse(__('messages.user_not_found'), Response::HTTP_NOT_FOUND);
        }

        if(!Hash::check($request->password, $user->password)) {
            return $this->errorResponse(__('messages.login_failed'), Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('API')->plainTextToken;

        return $this->successResponse(__('messages.login_successfully'), ['token' => $token]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $loggedInUser = auth('sanctum')->user();

        $loggedInUser->currentAccessToken()->delete();

        return $this->successResponse(__('messages.logout_successfully'));
    }
}
