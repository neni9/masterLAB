<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Class_level extends Model
{

	protected $fillable = 
    [
        'title'
    ];

    protected $title = 
    [
        'first_class'   => 'Première',
        'final_class'   => 'Terminale'
    ];

    /////////////////// RELATIONS ////////////////////////
    
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

     /////////////////// GETTERS ////////////////////////
    public function getTitleAttribute($value)
    {
        return $this->title[$value];
    }

}
