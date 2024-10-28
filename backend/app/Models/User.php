<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Связь с задачами, где пользователь является ответственным
    public function responsibleTasks()
    {
        return $this->hasMany(Task::class, 'responsible_user_id');
    }

    // Связь с задачами, где пользователь является постановщиком
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'creator_user_id');
    }
}
