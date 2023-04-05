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
        'day_date',
        'start_time',
        'end_time',
        'hour',
        'task_name',
        'task_day',
        'status',
        'description',        
    ];
}
