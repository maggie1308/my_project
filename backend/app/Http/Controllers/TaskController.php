<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Получение списка всех задач.
     */
    public function index(Request $request)
    {
        // Получаем задачи 
        $tasks = Task::where(function ($query) use ($request) {
            if ($request->has('responsible_user_id')) {
                $query->where('responsible_user_id', $request->input('responsible_user_id'));
            }
            if ($request->has('creator_user_id')) {
                $query->where('creator_user_id', $request->input('creator_user_id'));
            }
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->input('title') . '%');
            }
            if ($request->has('created_at')) {
                $query->whereDate('created_at', $request->input('created_at'));
            }
            if ($request->has('complete_at')) {
                $query->whereDate('complete_at', $request->input('complete_at'));
            }
        })->get();

        return response()->json($tasks);
    }

    /**
     * Создание новой задачи.
     */
    public function store(Request $request)
    {
        //dd('store method called');
        // Валидация входных данных
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'responsible_user_id' => 'required|exists:users,id',
            'complete_at' => 'nullable|date',
        ]);

        // Создание задачи
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'responsible_user_id' => $request->responsible_user_id,
            'creator_user_id' => Auth::id(), // Постановщик - текущий авторизованный пользователь
            'complete_at' => $request->complete_at,
        ]);
        //dd('store method called');
        //return response()->json($task, 201);
        return response()->json(['task' => $task, 'message' => 'Task created successfully'], 201);

    }

    /**
     * Получение задачи по её идентификатору.
     */
    public function show($id)
    {
        // Получение задачи по ID
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Обновление задачи по её идентификатору.
     */
    public function update(Request $request, $id)
    {
        // Получение задачи
        $task = Task::findOrFail($id);

        // Проверка, что текущий пользователь является постановщиком задачи
        if ($task->creator_user_id !== Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Валидация входных данных
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'responsible_user_id' => 'sometimes|exists:users,id',
            'complete_at' => 'nullable|date',
        ]);

        // Обновление задачи
        $task->update($request->all());

        return response()->json($task);
    }

    /**
     * Удаление задачи по её идентификатору.
     */
    public function destroy($id)
    {
        // Получение задачи
        $task = Task::findOrFail($id);

        // Проверка, что текущий пользователь является постановщиком задачи
        if ($task->creator_user_id !== Auth::id()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Удаление задачи
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
