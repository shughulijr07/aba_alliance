<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'timesheet_client_id',
        'user_id',
        'time',
        'task_name',
        'status',
        'description',        
    ];
}
