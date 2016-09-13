@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class=" top-row container-fluid">
    <div class="col-xs-12 main">
        <div class="row">
            <h2>{{$title}} 
                <small>Questions à choix simple ({{$total['simple']}}), Questions à choix multiples ({{$total['multiple']}}) </small>
            </h2>
            <div class="container-fluid panel panel-back">
                <div class="container-fluid">
                 
                    <form id='sort-form' method="get" action="{{url('admin/question')}}">
                        <input type="hidden" name="sortBy" value="{{$sortBy}}">
                        <input type="hidden" name="sortDir" value="{{$sortDir}}">
                        <button type="submit" class="nodisplay" >Valider</button>
                    </form>

                    <form class="form-inline" id='massupdate-form' method="post" action="/admin/qcmMassupdate">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="row-top"> Séléctionnez l'action souhaitée (Appliquer à tous les éléments cochés) </h4>
                                <div class="form-group col-md-6 ">
                                    <select name="massupdate" class="form-admin-input" required>
                                        <option value="0"></option>
                                        <option value="published">Publié</option>
                                        <option value="unpublished">Non publié</option>
                                        <option value="delete">Supprimer</option>
                                    </select>
                                </div>
                                <button type='submit' id='massupdateBtn' class='btn btn-dark'>Appliquer</button>
                                <a href="/admin/question/create">
                                <button type='button' class='btn  btn--modal--edit navbar-right'>Ajouter une question</button>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            @include('general.messages') 
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Question Incomplète : Il reste des choix à remplir avant de pouvoir publier cette question !
                            </div>
                        </div>
                        <div class='row'>
                            <div class="table-responsive">
                                <table class="table table-hover table-condensed custome--lab--table">
                                    <thead>
                                        <tr>
                                            <th class="label--table"><input type='checkbox' name='checkall'></th>
                                            <th class="label--table">Titre <i class="fa fa-sort" id='title' aria-hidden="true"></i></th>
                                            <th class="label--table">Classe <i class="fa fa-sort" id='class_level_id' aria-hidden="true"></i></th>
                                            <th class="label--table">Crée le <i class="fa fa-sort" id='created_at' aria-hidden="true"></i></th>
                                            <th class="label--table">Statut <i class="fa fa-sort" id='status' aria-hidden="true"></i></th>
                                            <th class="label--table">Type <i class="fa fa-sort" id='type' aria-hidden="true"></i></th>
                                            <th class="label--table text-center">Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($questions as $question)
                                        <tr class='{{isset($question->questionId) ? $question->questionId : $question->id}}'>
                                            <td><input type='checkbox' name='ids[]' value='{{isset($question->questionId) ? $question->questionId : $question->id}}'></td>
                                            <td>
                                                <a href="/admin/question/{{isset($question->questionId) ? $question->questionId : $question->id}}/edit">
                                                @if($sortBy == 'class_level_id')
                                                    {{$question->titleQuestion}}
                                                @else 
                                                    {{$question->title}}
                                                @endif
                                                </a>   
                                                    
                                                @if(isset($question->questionId))
                                                    @if($notCompleted[$question->questionId] == 0)
                                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
                                                    @endif
                                                @elseif($notCompleted[$question->id] == 0)
                                                     <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 
                                                @endif
                                            </td>
                                            <td>{{ is_null($question->class_level) ? 'NC' : $question->class_level->title }}</td>
                                            <td>{{!is_null($question->created_at) ? $question->created_at->format('d/m/Y') : 'NC'}}</td>
                                            <td>{{$question->status}}</td>
                                            <td>{{$question->type}}</td>
                                            <td class='text-center button-control' >
                                                <a href="/admin/question/{{isset($question->questionId) ? $question->questionId : $question->id}}/edit">
                                                    <button type="button" class="btn btn--modal--edit btn-bottom">Editer</button>
                                                </a>
                                                <button type="button" class="btn btn--modal--suppression btn-bottom deleteBtn" data-toggle="modal" data-target="#deleteQuestion" data-id="{{isset($question->questionId) ? $question->questionId : $question->id}}">
                                                    Supprimer
                                                </button>
                                                <div class="modal fade" id="deleteQuestion">
                                                    <form id="deleteForm" class="form-horizontal" action="{{url('/admin/question/'.$question->id)}}"  method="POST">
                                                        {{csrf_field()}}
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <span class="glyphicon glyphicon-remove"></span>
                                                                    </button>
                                                                    <h4 class="modal-title custom_align" id="Heading">Supprimer une question</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="alert alert-danger"> Voulez-vous vraiment supprimer cette question ?</div>
                                                                    <input type='hidden' name="_method" value='DELETE'>
                                                                </div>
                                                                <div class="modal-footer ">
                                                                    <button type="button" class="btn btn-danger" id="deleteQuestionBtn" >   Supprimer la question
                                                                    </button>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal fade" id="deleteManyModal">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </button>
                                                                <h4 class="modal-title custom_align" id="Heading">Supression multiple de questions</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="alert alert-danger"> 
                                                                    Voulez-vous vraiment supprimer les questions cochées?
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer ">
                                                                <button type="button" id='deleteManyBtn' class="btn btn-danger" >
                                                                    Valider la suppression
                                                                </button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                    Annuler
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>Il n'y a aucune question à administrer.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <div class='row'>
                        <div class="col-md-6 pull-left">
                            {!! $questions->appends(['sortBy' => $sortBy, 'sortDir' => $sortDir])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection