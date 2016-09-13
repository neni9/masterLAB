<?php

namespace App;

use DB;
use App\Choice;
use App\Score;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $fillable = [
        'title', 
        'content',
        'status',
        'class_level_id',
        'type',
        'explication'
    ];

    protected $statusLabel = 
    [
        'published'   => 'Publié',
        'unpublished' => 'Non Publié'
    ];

    /////////////////// RELATIONS ////////////////////////
    
    public function class_level()
    {
        return $this->belongsTo('App\Class_level');
    }

    public function choices()
    {
        return $this->HasMany('App\Choice'); 
    }

    public function picture()
    {
        return $this->hasOne('App\Picture');
    }

    public function scores()
    {
        return $this->HasMany('App\Score'); 
    }

    /////////////////// GETTERS ////////////////////////
    
    public function getTypeAttribute($value){
        
        return ucfirst($value);
    }

    public function getStatusAttribute($value)
    {
        return $this->statusLabel[$value];
    }

    /////////////////// CUSTOM SCOPE ////////////////////////
    public function scopeLast($query,$limit)
    {
         return $query->orderBy('created_at','desc')
              ->take($limit)
              ->get();
    }

    public function scopeLastTodo($query,$limit,$userId)
    {
         return  Score::with('question')
                    ->where('user_id', '=' , $userId)
                    ->where('status_question','notdone')
                    ->whereHas('question', function($query) {
                        $query->where('status', '=', 'published');
                    })
                    ->take($limit)
                    ->get();
    }

    public function scopeTotal($query)
    {
        return $query->count();
    }

    public function scopeTotalStatus($query,$status = 'published')
    {
        return $query->where('status','=',$status)
                     ->count();
    }

    public function scopeTotalType($query,$type = 'multiple')
    {
        return $query->where('type','=',$type)
                     ->count();
    }

    public function scopeTotalStatusPercent($query,$status = 'published')
    {
        $total = $query->count();
        $statusNb = ($this->scopeTotalStatus($query,$status) * 100);
        return round($statusNb / $total,2);
    }

    public function scopeTotalTypePercent($query,$type = 'multiple')
    {
        $total = $query->count();
        $typeNb = ($this->scopeTotalType($query,$type) * 100);
        return round($typeNb / $total,2);
    }

    public function scopePourcentageReussite($query)
    {
        $query = "SELECT questions.class_level_id, class_levels.title as 'level_title', note,count(*) as 'nbQcm', SUM(note) as 'sumnote'
                  FROM scores 
                  LEFT JOIN questions ON scores.question_id = questions.id
                  LEFT JOIN class_levels ON questions.class_level_id = class_levels.id 
                  WHERE status_question = 'done'
                  GROUP BY class_level_id
                  ORDER BY class_level_id,note;
                ";
        return DB::select( DB::raw($query) );
    }

    public function scopeGetQuestionsOrderBy($query,$sortBy,$sortDir)
    {
        
        if($sortBy == 'class_level_id'){
            $questions = Question::select(DB::raw('questions.*,class_levels.*, questions.title AS "titleQuestion", questions.id AS "questionId"'))
                ->join('class_levels', 'class_levels.id', '=', 'questions.class_level_id')
                ->groupBy('questions.id')
                ->orderBy('class_levels.id', $sortDir)
                ->paginate($this->paginate);
        }
        else{
            $questions  = Question::with('class_level')
                          ->orderBy($sortBy,$sortDir)
                          ->paginate($this->paginate);
        }

        return $questions;
        
    }

    public function scopeGetQuestionsForUserOrderBy($query,$sortBy,$sortDir,$userId)
    {
        $questions = Question::select(DB::raw('scores.status_question,scores.note,questions.id,questions.title'))
            ->leftjoin('class_levels', 'class_levels.id', '=', 'questions.class_level_id')
            ->leftjoin('scores', 'questions.id', '=', 'scores.question_id') 
            ->leftjoin('users', 'users.id', '=', 'scores.user_id') 
            ->leftjoin('roles', 'users.role_id', '=', 'roles.id') 
            ->where('users.id',$userId)
            ->where('questions.status','published')
            ->groupBy('questions.id')
            ->orderBy($sortBy, $sortDir)
            ->paginate($this->paginate);

        return $questions;
    }

    public function scopeTopCorrectQuestions($query,$limit)
    {
         $questions = Question::select(DB::raw('questions.id, questions.title, AVG(scores.note) AS "moyenne"'))
            ->leftjoin('scores', 'questions.id', '=', 'scores.question_id') 
            ->leftjoin('users', 'users.id', '=', 'scores.user_id') 
            ->where('questions.status','published')
            ->where('scores.status_question','done')
            ->where('users.status','actif')
            ->groupBy('questions.id')
            ->orderBy('moyenne', 'desc')
            ->orderBy('title','asc')
            ->take($limit)
            ->get();
        
        return $questions;
    }

    public function scopeTopScoreEleve($query,$limit,$orderDir)
    {
         $questions = Question::select(DB::raw('users.id,users.first_name,users.last_name, AVG(scores.note) AS "moyenne"'))
            ->leftjoin('scores', 'questions.id', '=', 'scores.question_id') 
            ->leftjoin('users', 'users.id', '=', 'scores.user_id') 
            ->where('questions.status','published')
            ->where('scores.status_question','done')
            ->where('users.status','actif')
            ->groupBy('users.id')
            ->orderBy('moyenne', $orderDir)
            ->orderBy('first_name','asc')
            ->take($limit)
            ->get();
        
        return $questions;
    }

    public function scopePublish($query,$question)
    {
        if($question->status == 'Publié') return sprintf("La question \"%s\" est déjà publiée.",$question->title); 

        $choicesNotComplete = Choice::where('question_id',$question->id)
                           ->where('content','<>',"")
                           ->where('content','<>',NULL)
                           ->count();
     
        if($choicesNotComplete == 0)
             return sprintf("La question \"%s\" ne peut être publiée car tous les choix ne sont pas complétés.",$question->title); 
        else{
            $question->update(['status' => 'published', 'published_at' => Carbon::now()]);

            return sprintf("La question \"%s\" a été publiée.",$question->title); 
        }
    }

    public function scopeUnpublish($query,$question)
    {
         if($question->status == 'Non Publié') return sprintf("La question \"%s\" est déjà non publiée.",$question->title);

         //check si des élèves ont déjà rep à la question
         $done = Score::where('question_id',$question->id)
                ->where('status_question','done')
                ->count();

        if($done > 0)
        {
            return sprintf("La question \"%s\" ne peut pas être dépublier car des élèves ont déjà répondu à la question.",$question->title);
        }
        else if($done == 0)
        {
            $question->update(['status' => 'unpublished', 'published_at' => NULL]);

            return sprintf("La question \"%s\"  a été dépubliée avec succès.",$question->title);
        }
        else{
            return sprintf("Erreur lors de la récupération de la question.");
        }



    }

}
