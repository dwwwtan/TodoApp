<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Js;

class TodoController extends Controller
{
    /**
     * Inject TodoService
     */
    public function __construct(
        protected TodoService $todoService
    ) {}

    // ========================================
    // INDEX - Get all todos for current user
    // ========================================
    public function index(Request $request): AnonymousResourceCollection
    {
        $todos = $this->todoService->getUserTodos($request->user());
        return TodoResource::collection($todos);
    }

    // ========================================
    // STORE - Create new todo
    // ========================================
    public function store(StoreTodoRequest $request): JsonResponse
    {
        $data = $request->validated();
        $todo = $this->todoService->createTodo($request->user(), $data);
        // return response()->json(new TodoResource($todo), 201);
        return new TodoResource($todo)
            ->response()
            ->setStatusCode(201);
    }

    // ========================================
    // SHOW - Get single todo details
    // ========================================
    public function show(Todo $todo): JsonResource
    {
        $this->authorize('view', $todo);
        $todo->loadMissing('user');
        // return response()->json(new TodoResource($todo));
        return new TodoResource($todo);
    }

    // ========================================
    // UPDATE - Chỉ update todo của user
    // ========================================
    public function update(UpdateTodoRequest $request, Todo $todo): JsonResource
    {
        $data = $request->validated();
        $updatedTodo = $this->todoService->updateTodo($todo, $data);
        // return response()->json(new TodoResource($updatedTodo), 201);
        return new TodoResource($updatedTodo);
    }

    // ========================================
    // DESTROY - Delete todo
    // ========================================
    public function destroy(Todo $todo): JsonResponse
    {
        $this->authorize('delete', $todo);
        $this->todoService->deleteTodo($todo);
        return response()->json([
            'message' => 'Todo deleted successfully'
        ]);
    }

    // ========================================
    // TOGGLE
    // ========================================
    public function toggle(Todo $todo): JsonResource
    {
        $this->authorize('toggle', $todo);
        $updatedTodo = $this->todoService->toggleTodo($todo);
        // return response()->json(new TodoResource($updatedTodo));
        return new TodoResource($updatedTodo);
    }
}