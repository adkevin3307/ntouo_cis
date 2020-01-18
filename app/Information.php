<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';
    protected $primaryKey = ['course_id', 'grade'];
    public $incrementing = false;
    public $timestamps = false;

    public function get_schedule_classroom()
    {
        return $this->hasMany('App\ScheduleClassroom', 'course_id', 'course_id')->select('schedule', 'classroom');
    }

    public function get_co_professors()
    {
        return $this->hasMany('App\CoProfessors', 'course_id', 'course_id');
    }

    public function get_messages()
    {
        return $this->hasMany('App\Messages', 'course_id', 'course_id');
    }
}
