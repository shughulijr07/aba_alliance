<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimesheetClient extends Model
{
    use HasFactory;
    protected $fillable = [
        'time_sheet_id',
        'project_id',    
    ];
}
