<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTask extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function task()
    {
        $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function user()
    {
        $this->belongsTo(User::class, 'user_id', 'id');
    }

}
