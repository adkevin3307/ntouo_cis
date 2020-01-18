<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'message_id';
    public $timestamps = false;
}
