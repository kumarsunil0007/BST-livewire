<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        $this->belongsToMany(User::class, StaffTask::class, 'task_id', 'user_id', 'id', 'id');
    }

    public function taskStatus()
    {
        $this->hasMany(StaffTask::class, 'task_id', 'id');
    }
}
