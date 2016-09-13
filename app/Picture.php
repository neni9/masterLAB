<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{

    protected $fillable = [
        'name',
        'uri',
        'size',
        'mime',
        'post_id',
        'question_id'
    ];

    /////////////////// RELATIONS ////////////////////////
    
    public function posts()
    {
        return $this->hasOne('App\Post');
    }

    public function questions()
    {
        return $this->hasOne('App\Question');
    }

  
}
