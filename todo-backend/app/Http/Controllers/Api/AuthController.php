<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Inject AuthService via Constructor
     */
    public function __construct(
        protected AuthService $authService
    ) {}

    // ========================================
    // REGISTER
    // ========================================
    public function register(RegisterRequest $request): JsonResponse
    {
        // 1. Validated data
        $data = $request->validated();

        // 2. Call Service
        $user = $this->authService->register($data);

        // 3. Return Resource
        return response()->json([
            'user' => new UserResource($user),
            'message' => 'Registration successful'
        ], 201);
    }

    // ========================================
    // LOGIN
    // ========================================
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        // Service handles attempt & throws exception if failed
        $user = $this->authService->login($credentials);

        return response()->json([
            'user' => new UserResource($user),
            'message' => 'Login successful'
        ]);
    }


    // ========================================
    // LOGOUT
    // ========================================
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Logged out']);
    }

    // ========================================
    // ME - Lấy thông tin user hiện tại
    // ========================================
    public function me(Request $request): JsonResponse
    {
        // Simple enough to keep here, or move to UserService if needed
        return response()->json([
            'user' => new UserResource($request->user())
        ]);
    }
}