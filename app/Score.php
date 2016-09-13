<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{

	protected $fillable = 
    [
        'status_question', 
        'note', 
        'user_id',
        'question_id'
    ];

     /////////////////// RELATIONS ////////////////////////
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    /////////////////// CUSTOM SCOPE ////////////////////////
    public function scopeTotalStatus($query,$status = 'done')
    {
        return $query->where('status_question','=',$status)
                     ->count();
    }

    public function scopeTotalStatusByUser($query,$status = 'done',$userId)
    {
        return $query->where('user_id','=',$userId)
                    ->where('status_question','=',$status)
                    ->count();
    }

    public function scopeTotalNoteByUser($query,$note = 1 ,$userId)
    {
        return $query->where('user_id','=',$userId)
                     ->where('status_question','=','done')
                     ->where('note','=',$note)
                     ->count();
    }

    public function scopeSumNote($query,$userId)
    {
        return $query->where('user_id','=',$userId)
                     ->where('status_question','=','done')
                     ->sum('note');
    }


}
