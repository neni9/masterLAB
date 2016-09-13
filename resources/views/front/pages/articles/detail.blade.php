@extends('layouts.site')
@section('title', $title)
@section('content') 

<div class="container-fluid m-bottom top-row">
       
    @include('general.messages')

    <div class="row m-bottom">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center">{{$post->title}}</h1>
            <p>
            @if(!is_null($post->user))
                Posté par <strong> {{$post->user->first_name}}  {{$post->user->last_name}} </strong>
            @else 
                Anonyme 
            @endif
                <br>
                <span class="single-quote-date">
                @if(!is_null($post->published_at))
                    Date de publication : <strong>{{$post->published_at->format('d/m/Y')}}</strong>
                @else 
                    Date de publication inconnue
                @endif
                </span>
            </p>
        </div>
    </div>
    <div class="row m-bottom">
        <div class="col-lg-8 col-lg-offset-2">
        @if(!is_null($post->picture))
            <img src="{{'/uploads/'.$post->picture->uri}}" alt="" class="img-responsive m-bottom img-center">
        @endif
            <br>
            <p>
                {!! $post->content !!}
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            @if($post->commentsCount == 0)
             <div class="col-md-12 top-row">
                <div class="nopost">Il n'y a aucun commentaires pour cet article.</div>
            </div>
            @else 
            <div class="thumbnail thumbnail-comments">
                <div class="caption">
                    <h2>{{$post->commentsCount}} Commentaire(s)</h2>
                    <hr>
                    @forelse($post->comments as $comment)
                        @if($comment->type == 'Valide' && $comment->status == 'Publié')
                            <div>
                                <h4 class='comment-title'>{{$comment->title}}</h4>
                                <p class="comment-author">Par 
                                @if(!is_null($comment->user_id))
                                    <span class="{{ ($comment->user->isAdmin()) ? 'teacher' : 'student' }}">{{$comment->pseudo}}</span>
                                @else 
                                    {{$comment->pseudo}}
                                @endif
                                le {{(!is_null($comment->created_at)) ? $comment->created_at->format('d/m/Y à H:i') : 'Date inconnue'}}</p>
                                <p class="comment-content">{{$comment->content}}</p>
                            </div>
                            <hr>
                        @endif 
                        @empty
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <h2>Poster un commentaire</h2>
            <form id='comment-form' role="form" method="POST" action="/comment">
                {{csrf_field()}}
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <div class="form-group">
                    <label class="input--lab--admin" for="#">Votre pseudo *</label>
                @if(Auth::check())
                    <input name="pseudo" value="" type="text" class="form-admin-input">
                    <input type="checkbox" name="identity" > Utiliser mon compte pour commenter (votre Nom et Prénom seront utilisés comme pseudo)
                    <span class="nodisplay" id="identityUser">{{auth()->user()->first_name." ".auth()->user()->last_name}}</span>
                @else 
                    <input name="pseudo" type="text" class="form-admin-input"  placeholder="Entrez votre pseudo/nom">
                @endif
                     @if($errors->has('pseudo')) <span class="error">{{$errors->first('pseudo')}} </span>@endif 
                     <span class="error js-error-pseudo"></span>
                </div>
                <div class="form-group">
                    <label class="input--lab--admin" for="#">Votre titre *</label>
                    <input name="title" type="text" class="form-admin-input" placeholder="Entrez votre titre">
                    @if($errors->has('title')) <span class="error">{{$errors->first('title')}} </span>@endif 
                    <span class="error js-error-title"></span>
                </div>
                <div class="form-group">
                    <label class="input--lab--admin" for="content">Votre message *</label>
                    <textarea name="content" class="form-admin-texterea"  placeholder="Tapez votre message" rows="3"></textarea>
                    @if($errors->has('content')) <span class="error">{{$errors->first('content')}} </span>@endif 
                    <span class="error js-error-content"></span>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-dark" type="submit">Envoyer </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection