@extends('layouts.site')
@section('title', $title)
@section('content') 

<div class="container-fluid">

    <div class="row">
        <h2>Nos articles à la une</h2>
    </div>

    <div class="row" id="posts">
        @forelse($lastPosts as $key => $post)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 item">
                <div class="thumbnail {{$key % 2 == 0 ? 'pair' : ''}}" >
                @if(!is_null($post->picture))
                    <img  src="{{'/uploads/'.$post->picture->uri}}" alt="{{(!is_null($post->picture->name) ? $post->picture->name : $post->picture->uri ) }}" class='img-responsive'>
                @endif
                    <div class="caption">
                        <h3>{{$post->title}}</h3>
                    @if($post->user)
                        <p>Par <strong>{{$post->user->first_name}} {{$post->user->last_name}} </strong></p>
                    @else
                        <p>Auteur inconnu</p>
                    @endif
                    @if(!is_null($post->published_at))
                        <p>Date de publication : <strong>{{$post->published_at->format('d/m/Y')}}</strong></p>
                    @else
                        <p>Date de publication inconnue</p>
                    @endif
                    @if(!empty($post->excerpt))
                        <p class='justify'>{{$post->excerpt}}</p>
                    @else
                        <p class="justify">{!! strip_tags(excerpt($post->content,90,'...')) !!}</p>
                    @endif
                        <p>
                            <a href="{{url('article',[$post->id])}}" class="btn btn-nav" role="button">Lire la suite</a>
                        </p>
                        <p>{{!is_null($post->commentsCount) ? $post->commentsCount : '0'}} commentaire(s)</p>
                        <div class="comments"></div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-sm-12 col-md-12 col-lg-12">
                Pas d'articles récents
            </div>
        @endforelse
    </div>
    <div class="clearfix"></div>
</div><!-- END CONTAINER-FLUID -->

@endsection