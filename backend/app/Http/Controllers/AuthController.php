<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Регистрация пользователя
     */
    public function register(Request $request)
    {
        // Валидация входных данных
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Создание нового пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Хэширование пароля
        ]);

        // Возвращаем успешный ответ
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * Авторизация пользователя
     */
    public function login(Request $request)
    {
        // Валидация входных данных
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Попытка авторизации пользователя
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Получаем авторизованного пользователя
        $user = Auth::user();

        // Генерация токена
        $token = $user->createToken('authToken')->plainTextToken;

        // Возвращаем токен и информацию о пользователе
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Выход пользователя и отзыв токенов
     */
    public function logout(Request $request)
    {
        // Удаление токенов пользователя
        $request->user()->tokens()->delete();

        // Возвращаем успешный ответ
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
