<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TaskProgress extends Model
{
    use HasFactory;

    protected $fillable = [
       'task_id',
        'day_date',
        'start_time',
        'end_time',
        'hour',
        'task_day',
        'task_status',
    ];

    public static function get_filled_task(){
        $data = DB::table('task_progress')
                ->join('tasks', 'task_progress.task_id', '=', 'tasks.id')
                ->select('task_progress.*','tasks.task_name');
        return $data;
    }
}
