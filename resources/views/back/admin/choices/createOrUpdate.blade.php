@extends('layouts.admin')
@section('title', $title)
@section('content')

 <div class="container-fluid">
     <div class="col-xs-12 col-sm-12 sol-md-12 sol-lg-12 main">
        <div class="row">
            <h2 class="heading-dash">
            @if (isset($question->id))
                Edition des choix (2/2)  - <i> Question {{$question->status}}</i>
            @else 
                Création des choix de réponses (2/2)
            @endif
            </h2>
            <div class="container-fluid panel panel-back">
                <div class="container-fluid">

                    <div class="row bs-lab">
                        <div class="col-xs-5 bs-lab-step complete">
                            <div class="text-center bs-lab-stepnum">
                                @if (isset($choix))
                                <a href="/admin/question/{{$question->id}}/edit" >Editer la question</a>
                                @else 
                                Création de la Question
                                @endif
                            </div>
                            <div class="progress">
                                <div class="progress-bar"></div>
                            </div>
                            <a href="#" class="bs-lab-dot"></a>
                            <div class="bs-lab-info text-center"></div>
                        </div>

                        <div class="col-xs-5 bs-lab-step active"><!-- active -->
                            <div class="text-center bs-lab-stepnum complete">
                                @if(isset($choix))
                                Editer les choix
                                @else 
                                Création des choix de réponses
                                @endif
                            </div>
                            <div class="progress">
                                <div class="progress-bar"></div>
                            </div>
                            <a href="#" class="bs-lab-dot"></a>
                            <div class="bs-lab-info text-center"> </div>
                        </div>
                    </div><!-- End.step -->

                     <div class="row">
                        @include('general.messages') 
                    </div>
                    
                    <div class="panel panel-default">
                        <div class="panel-body">
                            Rappel de la Question : <strong>{{$question->title}}</strong><br>
                            {{$question->content}}
                        </div>
                    </div>


                    <form method="POST" action="/admin/choice/store" id='choices-form'>

                        {{csrf_field()}}
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        <input type="hidden"name='question_type' value="{{$question->type}}">

                        <div class="row m-bottom">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                             @forelse($choix as $key => $reponse)
                                <input type="hidden" name="choice_ids[]" value="{{$reponse->id}}">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="input--lab--admin" for="content">Choix {{$key +1}}</label>
                                                <textarea name="content_{{$reponse->id}}" class="form-admin-texterea required"  rows="3">{{old('content',isset($reponse->content) ? $reponse->content : null)}}</textarea>
                                                @if($errors->has('content')) <span class="error">{{$errors->first('content')}}@endif
                                            </div>
                                        </div>
                                        @if($question->type == 'Multiple')
                                        <div class='text-center'>
                                            <input type="radio" name="status_{{$reponse->id}}" value="yes" class="required"
                                            @if (isset($reponse->status) && $reponse->status == 'yes')
                                               checked
                                            @endif
                                            > Vrai
                                            <input type="radio" name="status_{{$reponse->id}}" value="no" class="required"
                                            @if (isset($reponse->status) && $reponse->status == 'no')
                                               checked
                                            @endif
                                            >Faux
                                        </div>
                                        @else 
                                        <div class='text-center'>
                                              <input type="radio" name="status" value="{{$reponse->id}}" class="required" 
                                                @if (isset($reponse->status) && $reponse->status == 'yes')
                                                   checked
                                                @endif
                                              > Ce choix est la bonne réponse<br>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @empty
                                    Aucun choix n'a été créé. 
                                @endforelse
                                <div class='row'>
                                    <div class="col-md-10 col-md-offset-1 text-center">
                                        <span id="radio_error" class="error"></span>
                                    </div>
                                </div>
                                @if($question->status !== 'Publié')
                                <div class='row'>
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <input type="checkbox" name="published">
                                                <label class="input--lab--admin" for="published">Publier la question ? </label>
                                                @if($errors->has('published')) <span class="error">{{$errors->first('published')}} </span>@endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                    
                                <div class="col-md-4 col-md-offset-4 top-row">
                                    <button class="btn btn-dark " type="submit">
                                        Enregistrer les choix
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{url('assets/js/qcm.min.js')}}"></script>
@endsection
