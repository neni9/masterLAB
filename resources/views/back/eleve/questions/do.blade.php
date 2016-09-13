@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class=" container-fluid">
    <div class="col-xs-10 col-xs-offset-1 main">
        <div class="row">
            <h2>QCM - {{$title}}</h2>

            <div class="container-fluid panel panel-back">
                <div class="container-fluid row m-bottom">
                    @include('general.messages') 
                    <div class="col-md-12">
                        <div class='row'>
                            <h3>{{$question->content}}</h3>
                            <hr>
                            <p class="admin-quote">{{$subTitle}}</p>
                        </div>
                        @if($question->picture)
                        <div class='row text-center'>
                            <img src="/uploads/{{$question->picture->uri}}" max-width="600" class="img-responsive">
                        </div>
                        @endif
                    </div>
                </div>
                <form method="POST" action="" id='do-qcm-form'>
                    {{csrf_field()}}
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <input type="hidden" name="question_type" id="question_type" value="{{$question->type}}">
                    <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                    <div class="row m-bottom">
                        <div class="col-md-12">
                            <div class="form-group col-md-12">
                                <div class='choices'>
                                    @forelse($question->choices as $key => $choice)
                                    <div class="checkbox check--lab--admin">
                                        <label class="input--lab--admin {{$choice->id}}" for="#">
                                        @if($question->type == 'Simple')
                                        <input type="radio" name="choice" value="{{$choice->id}}" class="{{$choice->id}}"> {{$choice->content}}
                                        @else 
                                        <input type="checkbox" name="choices[]" value="{{$choice->id}}" class="{{$choice->id}}"> {{$choice->content}}
                                        @endif
                                        </label>
                                    </div>
                                    @empty 
                                    Erreur de chargement des réponses
                                    @endforelse
                                </div>
                            </div>
                            <div class="error errorForm nodisplay">
                                 <div class="row">
                                     <div class="col-md-6 col-md-offset-3">
                                        Vous devez choisir une réponse pour pouvoir valider la question.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input--lab--admin--panel-notif-color1 nodisplay" role="alert" id='correct'>
                                    <h4>Bravo!</h4>
                                    <p>
                                        Vous avez répondu correctement à la question, vous remportez 1 point ! 
                                    </p>
                                </div>
                                <div class="input--lab--admin--panel-notif-color2 nodisplay" role="alert" id='half-correct'>
                                    <h4>Pas mal !</h4>
                                    <p>
                                        Vous avez répondu partiellement correctement à la question. Vous remportez 0.5 point ! 
                                    </p>
                                </div>
                                <div class="input--lab--admin--panel-notif-color3 nodisplay" role="alert" id='wrong'>
                                    <h4>Dommage !</h4>
                                    <p>
                                        Vous n'avez pas répondu correctement à la question ! Vous ne remportez aucun point.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12  explication-block nodisplay">
                                <div class="input--lab--admin--panel-notif-color4">
                                    <h4>
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Explication des Professeurs
                                    </h4>
                                    <hr>
                                    <p class=' explication text-justify'></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-dark" type="button" id="submitDoForm">
                                Envoyer 
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection