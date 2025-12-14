<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    // ========================================
    // GET /api/todos - Lấy tất cả todos
    // ========================================
    public function index(): JsonResponse
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();

        return response()->json($todos);
    }

    // ========================================
    // POST /api/todos - Tạo todo mới
    // ========================================
    public function store(Request $request): JsonResponse
    {
        // Validate input
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'completed' => 'boolean'
        ]);

        // Tạo todo
        $todo = Todo::create([
            'text' => $validated['text'],
            'completed' => $validated['completed'] ?? false
        ]);

        return response()->json($todo, 201);  // 201 = Created
    }

    // ========================================
    // GET /api/todos/{id} - Lấy 1 todo
    // ========================================
    public function show(Todo $todo): JsonResponse
    {
        return response()->json($todo);
    }

    // ========================================
    // PUT/PATCH /api/todos/{id} - Update todo
    // ========================================
    public function update(Request $request, Todo $todo): JsonResponse
    {
        // Validate input
        $validated = $request->validate([
            'text' => 'sometimes|string|max:255',
            'completed' => 'sometimes|boolean'
        ]);

        // Update
        $todo->update($validated);

        return response()->json($todo);
    }

    // ========================================
    // DELETE /api/todos/{id} - Xóa todo
    // ========================================
    public function destroy(Todo $todo): JsonResponse
    {
        $todo->delete();

        return response()->json([
            'message' => 'Todo deleted successfully'
        ]);
    }

    // ========================================
    // PATCH /api/todos/{id}/toggle - Toggle completed
    // ========================================
    public function toggle(Todo $todo): JsonResponse
    {
        $todo->update([
            'completed' => !$todo->completed
        ]);

        return response()->json($todo);
    }
}