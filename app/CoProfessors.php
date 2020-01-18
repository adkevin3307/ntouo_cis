<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoProfessors extends Model
{
    protected $table = 'co_professors';
    protected $primaryKey = ['course_id', 'grade', 'index'];
    public $incrementing = false;
    public $timestamps = false;
}
