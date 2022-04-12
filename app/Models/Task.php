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
        return $this->belongsToMany(User::class, StaffTask::class, 'task_id', 'user_id', 'id', 'id')->withPivot('is_completed');
    }

    public function taskStatus()
    {
        return $this->hasOne(StaffTask::class, 'task_id', 'id');
    }

}
