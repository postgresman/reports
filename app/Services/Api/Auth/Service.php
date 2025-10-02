<?php

namespace App\Services\Api\Auth;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;

class Service
{
    public function login(array $credentials): JsonResponse
    {
        try {
            if (auth()->attempt($credentials)) {
                $user = auth()->user();
                $token = $user->createToken('api-token')->plainTextToken;

                return Response::json([
                    'success' => true,
                    'token' => $token,
                ], 200);
            }
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'An error occurred',
            ], 500);
        }

        return Response::json([
            'success' => false,
            'message' => 'Login failed',
        ], 401);
    }

    public function logout(): JsonResponse
    {
        try {
            if (!auth()->user()) {
                return Response::json([
                    'success' => false,
                    'message' => 'Not authenticated',
                ], 401);
            }

            auth()->user()->currentAccessToken()->delete();

            return Response::json([
                'success' => true,
                'message' => 'Logout successful',
            ], 200);
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'An error occurred',
            ], 500);
        }
    }
}