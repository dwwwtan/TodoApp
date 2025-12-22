<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ========================================
    // REGISTER
    // ========================================
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user); // Login user (tạo session)

        return response()->json([
            'user' => new UserResource($user),
            'message' => 'Registration successful'
        ], 201); // Session được lưu trong cookie tự động
    }

    // ========================================
    // LOGIN
    // ========================================
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Regenerate session (security)
        $request->session()->regenerate();

        return response()->json([
            'user' => new UserResource(Auth::user()),
            'message' => 'Login successful'
        ]);
    }


    // ========================================
    // LOGOUT
    // ========================================
    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out']);
    }

    // ========================================
    // ME - Lấy thông tin user hiện tại
    // ========================================
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($request->user())
        ]);
    }
}
