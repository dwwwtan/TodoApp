<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;

// ========================================
// TOD0 ROUTES
// ========================================
Route::apiResource('todos', TodoController::class);

// ☝️ Tạo tất cả routes CRUD:
// GET    /api/todos           → index()
// POST   /api/todos           → store()
// GET    /api/todos/{id}      → show()
// PUT    /api/todos/{id}      → update()
// PATCH  /api/todos/{id}      → update()
// DELETE /api/todos/{id}      → destroy()


// ========================================
// CUSTOM ROUTE - Toggle
// ========================================
Route::patch('todos/{todo}/toggle', [TodoController::class, 'toggle']);
