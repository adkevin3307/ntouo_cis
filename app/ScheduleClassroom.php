<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleClassroom extends Model
{
    protected $table = 'schedule_classroom';
    protected $primaryKey = ['course_id', 'grade', 'index'];
    public $incrementing = false;
    public $timestamps = false;
}
