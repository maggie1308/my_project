<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

// Маршруты для работы с пользователями: регистрация и логин
Route::post('/user/registration', [AuthController::class, 'register']);
Route::post('/user/login', [AuthController::class, 'login']);

// Защищенные маршруты для задач (доступны только авторизованным пользователям)
Route::middleware('auth:sanctum')->group(function () {
    // Получение списка всех задач
    Route::get('/tasks', [TaskController::class, 'index']);
    
    // Создание новой задачи
    Route::post('/tasks', [TaskController::class, 'store']);
    
    // Получение задачи по её идентификатору
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    
    // Обновление задачи по её идентификатору
    Route::patch('/tasks/{id}', [TaskController::class, 'update']);
    
    // Удаление задачи по её идентификатору
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
});

