@extends('layouts.site')
@section('title', $title)
@section('content') 


<div class="container-fluid">
    <div class="row m-bottom">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h1 class="text-center"><span class="single-heading-search">
                Resultats de recherche - </span>{{$total}} article(s)
            </h1>
            <p> Pour la recherche : 
                <span class="single-quote">{{$title}} </span>
            </p>
        </div>
    </div>

    <div class="row m-bottom">
        <div class="col-lg-8 single-list-search">
            <ul>
            @forelse($posts as $post)
                <li><a href="/article/{{$post->id}}">{{$post->title}}</a></li>
            @empty 
                <li>Aucun article trouvé pour cette recherche. </li>
            @endforelse
            </ul>
        </div>
    </div>
    
    <div class='text-center'>{!! $posts->appends(['search' => $searchTerm])->render() !!}</div>
</div>

@endsection