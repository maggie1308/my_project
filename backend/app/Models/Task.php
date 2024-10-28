<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['responsible_user_id', 'creator_user_id', 'title', 'description', 'complete_at'];

    // Связь с моделью User (ответственный пользователь)
    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    // Связь с моделью User (постановщик задачи)
    public function creatorUser()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }
}
