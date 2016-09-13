<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;

use DB;
use App\Score;
use App\User;
use App\Post;
use App\Role;

class User extends Authenticatable
{
  
    protected $fillable = 
    [
        'email', 
        'username', 
        'first_name',
        'last_name',
        'password',
        'role_id',
        'class_level_id'
    ];

    protected $hidden = 
    [
        'password', 
        'remember_token',
    ];

    /////////////////// RELATIONS ////////////////////////

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function class_level()
    {
        return $this->belongsTo('App\Class_level');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function scores()
    {
        return $this->hasMany('App\Score');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }


    /////////////////// GETTERS ////////////////////////
     

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    public function getFirst_nameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getLast_nameAttribute($value)
    {
        return ucfirst($value);
    }

    /////////////////// CUSTOM SCOPE & METHODS  //////////////////////// 
    

    /**
     * isAdmin check if a user has the role teacher (admin)
     * 
     * @return boolean 
     */
    public function isAdmin()
    {
        return ($this->role->title === 'Professeur') ? true : false; 
    }

    /**
     * isEditor check if a user has the role student
     * 
     * @return boolean 
     */
    public function isStudent()
    {
        // dd($this->role->title !== 'Professeur');
        return ($this->role->title == 'Eleve') ? true : false; 
    }

    /**
     * ownPost check if a user has write a post 
     * @param  Post   $post post to check
     * @return boolean
     */
    public function ownPost(Post $post)
    {
        return ($post->user_id === $this->id) ? true : false; 
    }

    public function scopeTotal($query,$role)
    {
        return $query->where('status','=','actif')
                    ->where('role_id','=',$role)
                    ->count();
    }

    public function scopeTotalByClasses($query)
    {
        return $query->where('status','=','actif')
                    ->where('role_id','=',2)
                    ->groupBy('class_level_id')
                    ->get();

        $query = "SELECT class_levels.title, count(*)
                  FROM users 
                  LEFT JOIN class_levels ON users.class_level_id = class_levels.id 
                  WHERE users.status = 'actif' AND users.role_id = 2
                  GROUP BY class_level_id
                  ORDER BY class_levels.title;
                ";
        return DB::select( DB::raw($query) );
    }

    public function scopeGetElevesBySort($query,$sortBy,$sortDir)
    {
        if($sortBy == 'class_level_id'){
            $eleves = User::select(DB::raw('users.*,class_levels.*,roles.*,users.id AS "userId"'))
                    ->leftjoin('class_levels', 'class_levels.id', '=', 'users.class_level_id')
                    ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
                    ->where('roles.id','=',2)
                    ->groupBy('users.id')
                    ->orderBy('class_levels.id', $sortDir)
                    ->paginate($this->paginate);
        }
        else if($sortBy == 'score'){
             $eleves = User::select(DB::raw('users.*,class_levels.*,roles.*,scores.*, sum(note) AS "aggregate",users.id AS "userId"'))
                    ->leftjoin('class_levels', 'class_levels.id', '=', 'users.class_level_id')
                    ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
                    ->leftjoin('scores', 'scores.user_id', '=', 'users.id')
                    ->where('roles.id','=',2)
                    ->groupBy('users.id')
                    ->orderBy('aggregate', $sortDir)
                    ->paginate($this->paginate);
        }else{
            $eleves  = User::with('role','class_level')
                      ->where('role_id','=',2)
                      ->orderBy($sortBy,$sortDir)
                      ->paginate($this->paginate);
        }

        return $eleves;
    }

}
