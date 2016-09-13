<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = 
    [
        'pseudo',
        'title',
        'content',
        'post_id',
        'user_id'
    ];

    protected $status = 
    [
        'published'   => 'Publié',
        'unpublished' => 'Non Publié'
    ];

    protected $type = 
    [
        'valid'     => 'Valide',
        'spam'      => 'Spam',
        'unchecked' => 'Non Vérifié'
    ];

    /////////////////// RELATIONS ////////////////////////
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /////////////////// GETTERS ////////////////////////
    public function getPseudoAttribute($value)
    {
        return ucfirst($value);
    }

    public function getContentAttribute($value)
    {
        return ucfirst($value);
    }

    public function getTypeAttribute($value)
    {
        return $this->type[$value];
    }

    public function getStatusAttribute($value)
    {
        return $this->status[$value];
    }

    /////////////////// CUSTOM SCOPE ////////////////////////
    public function scopeGetCommentsBySort($query,$sortBy,$sortDir)
    {
        $comments  = Comment::with('post','user')
                  ->orderBy($sortBy,$sortDir)
                  ->paginate($this->paginate);

        return $comments;
       
    }
}
