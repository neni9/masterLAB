@extends('layouts.site')
@section('title', $title)
@section('content') 
	
<section class="container-fluid">
    <div class="row">
        <h2>Liste des actualités</h2>

        <article class="timeline-entry " >

            <div class="timeline-label top-row">
                <h4>
                    <span class="timeline-label-date"> {{$displayDate}}</span> 
                    -<span class="timeline-label-quote"> {{$posts->count()}} article(s)</span>
                </h4>
            </div>

            @forelse($posts as $post)
            <div class="col-md-12 top-row">
                <div class="list-group">
                    <div class="hidden-xs col-sm-6 col-md-6 col-lg-6">
                        @if(!is_null($post->picture))
                            <img src="{{'/uploads/'.$post->picture->uri}}" class='img-responsive img-center'>
                        @else 
                             <img src="/images/default.jpg" class='img-responsive img-center'>
                        @endif
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <h3 class="list-group-item-heading">{{$post['title']}} </h3>   
                        <p>
                            Posté par <strong>{{$post['user']['first_name']}} {{$post['user']['last_name']}}</strong> le <strong>{{$post['published_at']->format('d/m/Y')}}</strong>
                            <br>
                             {{$post->commentsCount}} commentaire(s) <i class="fa fa-comment" aria-hidden="true"></i>
                        </p>
                        <div class="visible-xs">
                            @if(!is_null($post->picture))
                                <img src="{{'/uploads/'.$post->picture->uri}}" class='img-responsive img-center'>
                            @else 
                                <img src="/images/default.jpg" class='img-responsive img-center'>
                            @endif
                        </div>
                         @if(!empty($post->excerpt))
                        <p class='justify top-row'>{{$post->excerpt}}</p>
                        @else
                            <p class="justify  top-row">{!! strip_tags(excerpt($post->content,90,'...')) !!}</p>
                        @endif
                        <p class='pull-right'>
                            <a href="{{url('article',[$post->id])}}" class="btn btn-blog" role="button">
                                Lire la suite...
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            @empty 
            <div class="col-md-12 top-row">
                <div class="nopost">Désolé ! Il n'y a aucun article pour ce mois-ci =(</div>
            </div>
            @endforelse
            
            <hr>

            <div class='row'>
                <span class='hidden' id='next_month'>{{(!is_null($next)) ? $next->format('m') : ''}}</span>
                <span class='hidden' id='next_year'> {{(!is_null($next)) ? $next->format('Y') : ''}}</span>
                <span class='hidden' id='prev_month'>{{(!is_null($previous)) ? $previous->format('m') : ''}}</span>
                <span class='hidden' id='prev_year'>{{(!is_null($previous)) ? $previous->format('Y') : ''}}</span>

                <form id='paginate-form' method="get" action="{{url('/actualites')}}">
                    <div class='col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 text-center  top-row'>
                        <div class="row">
                            <input type="hidden" name="month"  value="">
                            <input type="hidden" name="year"   value="">
                            @if(!is_null($nextDisplay))                               
                                <button class='btn btn-dark' type="button" id='next'>
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i> {{$nextDisplay}}
                                </button>
                            @endif 

                            @if(!is_null($prevDisplay))
                                <button class='btn btn-dark' type="button" id='previous'>
                                    {{$prevDisplay}} <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </button>
                            @endif
                        </div>
                        <div class="row">
                            <label for="selectMonth" class="col-md-12">Accéder directement à un mois en particulier : </label>
                        </div>
                        <div class='row'>
                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                <select name="selectMonth" class='form-control' >
                                    <option value="0"></option>
                                    @if(!empty($selectMonthOptions))
                                    {!! $selectMonthOptions !!}
                                    @endif
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                <button class='btn btn-dark ' type="button" id='selectBtn'>
                                    Accéder <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </article>

    </div>
</section>


@endsection