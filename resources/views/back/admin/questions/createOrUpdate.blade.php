@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class=" top-row container-fluid">
    <div class="col-xs-12 main">
        <div class="row">
            <h2 class="heading-dash">
                @if (isset($question->id))
                Edition de la question (1/2)  - <i>{{$question->status}}</i>
                @else 
                Nouvelle Question (1/2)
                @endif
            </h2>
            
            <div class="container-fluid panel panel-back">
                <div class="container-fluid">
                 
                    <div class="row bs-lab">
                        <div class="col-xs-5 bs-lab-step complete">
                            <div class="text-center bs-lab-stepnum">
                                @if (isset($question->id))
                                Edition de la question
                                @else 
                                Création de la Question
                                @endif
                            </div>
                            <div class="progress">
                                <div class="progress-bar"></div>
                            </div>
                            <a href="#" class="bs-lab-dot"></a>
                            <div class="bs-lab-info text-center">
                            </div>
                        </div>
                        <div class="col-xs-5 bs-lab-step disabled">
                            <div class="text-center bs-lab-stepnum">
                                @if(isset($question->id))
                                <a href="{{url('admin/choice/'.$question->id)}}" >Voir et éditer les choix</a>
                                @else 
                                Création des choix de réponses
                                @endif
                            </div>
                            <div class="progress">
                                <div class="progress-bar"></div>
                            </div>
                            <a href="#" class="bs-lab-dot"></a>
                            <div class="bs-lab-info text-center"> 
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @include('general.messages') 
                    </div>

                    <!-- End.step -->
                    @if (isset($question->id))
                    <form method="POST" action="{{url('admin/question/'.$question->id)}}" id='question-form'  enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        @else 
                    <form method="POST" action="{{url('admin/question')}}" id='question-form'  enctype="multipart/form-data">
                        @endif
                        {{csrf_field()}}
                        <div class="row m-bottom">
                            <div class="col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="title" class="input--lab--admin" >Titre de la question *</label>
                                    <input type="text" name="title" class="form-admin-input" value="{{old('title',isset($question->title) ? $question->title : null)}}">
                                    @if($errors->has('title')) <span class="error">{{$errors->first('title')}}@endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="input--lab--admin" for="nbchoix">Nombre de choix *</label>
                                    <input  type="number" min="2" name="nbchoix" value="{{old('nbchoix',isset($question->choices) ? $question->choices->count() : null)}}" class="form-admin-input" placeholder="Nombre de choix"
                                    @if(isset($question->id))
                                    disabled readonly
                                    @endif
                                    >
                                    @if($errors->has('nbchoix')) <span class="error">{{$errors->first('nbchoix')}}@endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="input--lab--admin" for="class_level_id">Niveau *</label>
                                    <select class="form-admin-input" name="class_level_id">
                                        <option value=""></option>
                                        <option value="1"   
                                        @if (isset($question->class_level_id) && $question->class_level_id == 1)
                                        selected
                                        @endif
                                        >Première</option>
                                        <option value="2"
                                        @if (isset($question->class_level_id) && $question->class_level_id == 2)
                                        selected
                                        @endif
                                        >Terminale</option>
                                    </select>
                                    @if($errors->has('class_level_id')) <span class="error">{{$errors->first('class_level_id')}}@endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="input--lab--admin" for="type">Type *</label>
                                    @if(!isset($question->id))
                                    <select class="form-admin-input" name="type">
                                        <option value=""></option>
                                        <option value="simple"
                                        @if (isset($question->type) && $question->type == 'Simple')
                                        selected
                                        @endif
                                        >Simple</option>
                                        <option value="multiple"
                                        @if (isset($question->type) && $question->type == 'Multiple')
                                        selected
                                        @endif
                                        >Multiple</option>
                                    </select>
                                     @else 
                                    <input type="text" name="type" value="{{$question->class_level->title}}" class="form-admin-input" disabled readonly> 
                                    <select class="form-admin-input nodisplay" name="type" type="hidden">
                                        <option value="simple"
                                        @if (isset($question->type) && $question->type == 'Simple')
                                        selected
                                        @endif
                                        >Simple</option>
                                        <option value="multiple"
                                        @if (isset($question->type) && $question->type == 'Multiple')
                                        selected
                                        @endif
                                        >Multiple</option>
                                    </select>
                                    @endif
                                    @if($errors->has('type')) <span class="error">{{$errors->first('type')}}@endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="input--lab--admin">Nom de l'image</label>
                                        <input type="text" name="picture_name" class="form-admin-input" value="{{old('picture_name',isset($question->picture) ? $question->picture->name : null)}}">
                                        @if($errors->has('picture_name')) <span class="error">{{$errors->first('picture_name')}}@endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="picture" class="input--lab--admin">
                                        @if(isset($question->picture))
                                        Remplacer l'image par une nouvelle 
                                        @else 
                                        Lier une image à cet article 
                                        @endif
                                        </label>
                                        <input type="file" name="picture" class="form-admin-input" value="{{old('picture',isset($question->picture) ? $question->picture : null)}}">
                                        @if($errors->has('picture')) <span class="error">{{$errors->first('picture')}}@endif
                                    </div>
                                </div>
                                @if(isset($question->picture))
                                <div class="col-md-12">
                                    <div class="row">
                                        <p class='text-center'><b>Image actuelle :</b></p>
                                        <img class='img-responsive' style="display:block;margin:auto;max-width:650px;" src="/uploads/{{$question->picture->uri}}">
                                    </div>
                                    <div class="row text-center">
                                        <label for="deleteImage" class="input--lab--admin">Supprimer l'image ? Oui </label>
                                        <input type="checkbox" name="deleteImage">
                                    </div>
                                </div>
                                @endif
                                <div class="form-group col-md-12">
                                    <label class="input--lab--admin" for="content">Rédaction de la question *</label>
                                    <textarea name="content" class="form-admin-texterea"  rows="3">{{old('content',isset($question->content) ? $question->content : null)}}</textarea>
                                    @if($errors->has('content')) <span class="error">{{$errors->first('content')}}@endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="input--lab--admin" for="explication">Rédaction de l'explication</label>
                                    <textarea name="explication" class="form-admin-texterea"   rows="3">{{old('explication',isset($question->explication) ? $question->explication : null)}}</textarea>
                                    @if($errors->has('explication')) <span class="error">{{$errors->first('explication')}}@endif
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-dark " type="submit">
                                    @if (isset($question->id))
                                    Editer la question aller à la page des choix >>>
                                    @else 
                                    Créer la question et passer à la création des choix >>>
                                    @endif
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