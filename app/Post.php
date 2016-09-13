<?php

namespace App;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	protected $fillable = 
    [
        'title',
        'excerpt',
        'content',
        'status',
        'user_id',
        'published_at'
    ];

    protected $dates = ['published_at'];

    protected $status = 
    [
        'published'   => 'Publié',
        'unpublished' => 'Non Publié'
    ];

    protected $allowable_tags = "<p><s><u><em><strong><ul><ol><li><hr /><hr><h1><h2><h3><h4><table><tbody><tr><td><th><thead><sub><blockquote>";

    /////////////////// RELATIONS ////////////////////////
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function picture()
    {
        return $this->hasOne('App\Picture');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function commentsCount()
    {
        return $this->hasOne('App\Comment')
               ->selectRaw('post_id, count(*) as count')
               ->where('type','=','valid')
               ->where('status','=','published')
               ->groupBy('post_id');
    }

    /////////////////// GETTERS ////////////////////////
    public function getCommentsCountAttribute()
    {
      if ($this->relationLoaded('commentsCount')) 
        $this->load('commentsCount');

      $related = $this->getRelation('commentsCount');

      return ($related) ? (int) $related->count : 0;
    }

    public function getStatusAttribute($value)
    {
        return $this->status[$value];
    }

    public function getTitleAttribute($value)
    {
        return ucfirst($value);
    }

    public function getExcerptAttribute($value)
    {
        return ucfirst($value);
    }

    public function getContentAttribute($value)
    {
        return ucfirst($value);
    }

    /////////////////// CUSTOM SCOPE ////////////////////////
     
    public function scopePublished($query)
    {   
        return $query->where('status','=','published');
    } 

    public function scopeUnpublished($query)
    {   
        return $query->where('status','=','unpublished');
    } 

    public function scopeOrderByPublished($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeLast($query,$limit = 3)
    {
        return $query->orderBy('created_at','desc')
                      ->take($limit)
                      ->get();
    }

    public function scopeTop($query,$limit = 5)
    {
        return $query->select(DB::raw('posts.*, count(*) as `aggregate`'))
                        ->leftJoin(DB::raw('(select * from comments) as com'), 'posts.id', '=', 'com.post_id')
                        ->groupBy('post_id')
                        ->orderBy('aggregate', 'desc')
                        ->take($limit)
                        ->get();
         
    }

    public function scopeByMonth($query,$limit = false,$status = false)
    {
        if($status && $limit){
            return $query->where('status','=',$status)
                             ->orderBy('published_at','desc')
                            ->get()
                            ->groupBy(function($date) {
                                return Carbon::parse($date->published_at)->format('m-Y'); 
                            })->take($limit);
        }
        else{
            return $query->orderBy('published_at','desc')
                            ->get()
                            ->groupBy(function($date) {
                                return Carbon::parse($date->published_at)->format('m-Y'); 
                            });
        }
    }

    public function scopeGetLastDatePost($query)
    {
        return Post::select("published_at")
                     ->where('status','=','published')
                     ->orderBy('published_at','desc')->get()->first();
    }

    public function scopeGetFirstDatePost($query)
    {
        return Post::select("published_at")
                     ->where('status','=','published')
                     ->orderBy('published_at','asc')->get()->first();
    }

    public function scopeGetSelectByMonth($query)
    {
        $posts =  $query->where('status','=','published')
                          ->orderBy('published_at','desc')
                            ->get()
                            ->groupBy(function($date) {
                                return Carbon::parse($date->published_at)->format('m-Y'); // grouping by months
                            });

        $selectOptions = "<options value='0'></option>";

        foreach ($posts as $date => $posts) 
            $selectOptions .= sprintf("<option value='%s'>%s</option>",$date, $this->getDateLabel($date)." (".$posts->count().")"); 

        return $selectOptions;
    }

    public function scopeMonth($query,$month,$year,$status = false)
    {
        if($status){
            return $query->with('commentsCount','picture')
                         ->where('status','=',$status)
                         ->whereMonth('published_at','=',$month)
                         ->whereYear('published_at','=',$year)
                         ->orderBy('published_at','desc')
                         ->get();
        }
        else{
             return $query->with('commentsCount','picture')
                         ->where('status','=',$status)
                         ->whereMonth('published_at','=',$month)
                         ->whereYear('published_at','=',$year)
                         ->orderBy('published_at','desc')
                         ->get();
        }
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

    public function scopeTotalStatusPercent($query,$status = 'published')
    {
        $total = $query->count();
        $statusNb = ($this->scopeTotalStatus($query,$status) * 100);
        return $statusNb / $total;
    }

    public function scopeGetPostsOrderBy($query,$sortBy,$sortDir)
    {
        if($sortBy == 'first_name'){
            $posts = Post::select(DB::raw('posts.*, count(*) as `commentsCount`'))
                ->join('comments', 'comments.post_id', '=', 'posts.id')
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->groupBy('posts.id')
                ->orderBy('users.first_name', $sortDir)
                ->paginate($this->paginate);
        }
        else if($sortBy == 'comments'){
            $posts = Post::select(DB::raw('posts.*, count(*) as `commentsCount`'))
                ->join('comments', 'comments.post_id', '=', 'posts.id')
                ->groupBy('posts.id')
                ->orderBy('commentsCount', $sortDir)
                ->paginate($this->paginate);
        }
        else{
            $posts  = Post::with('commentsCount', 'user')
                          ->orderBy($sortBy,$sortDir)
                          ->paginate($this->paginate);
        }

        return $posts;
        
    }

    public function scopeGetMonth($query,$month)
    {
        $mois = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

        return $mois[$month-1];
    }

    public function tradMonth($month)
    {
        $mois = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

        return $mois[$month-1];
    }

    private function getDateLabel($date)
    {
        $month = substr($date,0,2);
        return $this->tradMonth($month)." ".substr($date,3,5);
    }

    /**TEST**/
    public function getMonthId($month)
    {
        $mois = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

        $value = substr($month,0,2);

        return $mois[(int)$value -1].'_'.substr($month,3,5); 
    }

    public function scopePrepare($query, $request)
    {
        $data = $request;

        $data['user_id'] = Auth()->user()->id;
        $data['content'] = strip_tags($data['content'],$this->allowable_tags);

        if($data['status'] == 'published')
            $data['published_at'] = Carbon::now();
        
        return $data;
    }

    private function upload($im,$name,$postId)
    {    
        $ext = $im->getClientOriginalExtension();   
        $uri = str_random(50).'.'.$ext;     
        $picture = Picture::create([
            'name'    => $name,
            'uri'     => $uri, 
            'size'    => $im->getSize(),
            'mime'    => $im->getClientMimeType()
        ]);

        $im->move(env('UPLOAD_PICTURES','uploads'),$uri);

        Post::where('id','=',$postId)
              ->update(['picture_id' => $picture->id]);

        return true;
    }

    public function scopeUploadPicture($query,$file,$pictureName,$postId)
    {
        $this->upload($file,$pictureName,$postId);
        $post       = Post::findOrFail($postId);

        return Picture::findOrFail($post->picture_id);
    }

    public function scopeUnpublish($query,$post)
    {
        $post->update([
            'status' => 'unpublished', 
            'published_at' => NULL
        ]);
    }

    public function scopePublish($query,$post)
    {
        $post->update([
            'status' => 'published', 
            'published_at' => Carbon::now()
        ]);
    }

}
