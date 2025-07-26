<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)
                    ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return (new JsonResponse(['error' => 'Invalid credentials!'], 401));
        }

        return new JsonResponse([
            'access_token' => $user->createToken('access_token')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()
                ->currentAccessToken()
                ->delete();

        return new JsonResponse(['message' => 'user signed out successfully!']);
    }
}
