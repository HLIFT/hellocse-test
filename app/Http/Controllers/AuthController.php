<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();

            $token = $user->createToken('authToken');

            return response()->json([
                'token' => $token->plainTextToken,
            ]);
        }

        return response()->json([
            'message' => 'Email ou mot de passe incorrect.'
        ], 401);
    }
}
