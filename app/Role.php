<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = 
    [
        'title'
    ];

    protected $roles = 
    [
        'teacher'       => 'Professeur',
        'student'       => 'Eleve'
    ];

    /////////////////// RELATIONS ////////////////////////
    
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /////////////////// GETTERS ////////////////////////
    
    public function getTitleAttribute($value)
    {
        return $this->roles[$value];
    }
}
