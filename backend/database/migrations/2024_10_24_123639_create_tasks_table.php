<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // ID задачи
            $table->foreignId('responsible_user_id')->constrained('users'); // Ответственный пользователь
            $table->foreignId('creator_user_id')->constrained('users'); // Постановщик задачи
            $table->string('title'); // Название задачи
            $table->text('description')->nullable(); // Описание задачи (может быть пустым)
            $table->timestamp('complete_at')->nullable(); // Дата завершения задачи
            $table->timestamps(); // Время создания и обновления записи
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
