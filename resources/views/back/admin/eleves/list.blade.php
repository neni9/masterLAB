@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="container-fluid">
    <div class="col-xs-12 main">
        <div class="row">
            <h2>{{$title}}
                <small>Eleves de Première ({{$total['first_class']}}), Eleves de Terminale ({{$total['last_class']}}) </small> 
            </h2>
           
            <div class="container-fluid panel panel-back">
                <div class="container-fluid top-row">
                  
                    <form id='sort-form' method="get" action="{{url('admin/eleve')}}">
                        <input type="hidden" name="sortBy" value="{{$sortBy}}">
                        <input type="hidden" name="sortDir" value="{{$sortDir}}">
                        <button type="submit" class="nodisplay">Valider</button>
                    </form>

                    <form class="form-inline" id='massupdate-form' method="post" action="{{url('admin/eleveMassupdate')}}">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="row-top"> Séléctionnez l'action souhaitée (Appliquer à tous les éléments cochés) </h4>
                                <div class="form-group col-md-6 ">
                                    <select name="massupdate" class="form-admin-input" required>
                                        <option value="0"></option>
                                        <option value="status&actif">Actif</option>
                                        <option value="status&inactif">Inactif</option>
                                        @forelse($classlevels as $classe)
                                        <option value="class_level_id&{{$classe->id}}">{{$classe->title}}</option>
                                        @empty 
                                        @endforelse
                                        <option value="delete">Supprimer</option>
                                    </select>
                                </div>
                                <button type='submit' id='massupdateBtn' class='btn btn-dark'>Appliquer</button>
                            </div>
                        </div>

                        <div class="row">
                            @include('general.messages') 
                        </div>

                        <div class='row top-row'>
                            <div class="table-responsive">
                                <table class="table table-hover table-condensed custome--lab--table">
                                    <thead>
                                        <tr>
                                            <th class="label--table">
                                                <input type='checkbox' name='checkall'>
                                            </th>
                                            <th class="label--table">
                                                Prénom <i class="fa fa-sort" id='first_name' aria-hidden="true"></i>
                                            </th>
                                            <th class="label--table">
                                                Nom <i class="fa fa-sort" id='last_name' aria-hidden="true"></i>
                                            </th>
                                            <th class="label--table">
                                                Email  <i class="fa fa-sort" id='email' aria-hidden="true"></i>
                                            </th>
                                            <th class="label--table">
                                                Crée le <i class="fa fa-sort" id='created_at' aria-hidden="true"></i>
                                            </th>
                                            <th class="label--table">
                                                Classe  <i class="fa fa-sort" id='class_level_id' aria-hidden="true"></i>
                                            </th>
                                            <th class="label--table">
                                                Statut <i class="fa fa-sort" id='status' aria-hidden="true"></i>
                                            </th>
                                            <th class="label--table">
                                                Score <i class="fa fa-sort" id='score' aria-hidden="true"></i>
                                            </th>
                                            <th class="label--table">
                                                Actions 
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($eleves as $eleve)
                                        <tr class='{{$eleve->id}}'>
                                            <td><input type='checkbox' name='ids[]' value='{{(isset($eleve->userId)) ? $eleve->userId : $eleve->id}}'></td>
                                            <td>{{$eleve->first_name}}</td>
                                            <td>{{$eleve->last_name}}</td>
                                            <td>{{$eleve->email}}</td>
                                            <td>{{!is_null($eleve->created_at) ? $eleve->created_at->format('d/m/Y') : 'NC'}}</td>
                                            <td>{{$eleve->class_level->title }}</td>
                                            <td class='text-center' ><span class="">
                                                {{$eleve->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if(isset($eleve->aggregate))
                                                {{$eleve->aggregate}} pt(s)
                                                @else 
                                                {{$eleve->scores->sum('note')}} pt(s)
                                                @endif
                                            </td>
                                            <td class='text-center button-control' >
                                                <button type="button" class="btn btn--modal--suppression btn-bottom deleteBtn" data-toggle="modal" data-target="#deleteEleve"  data-id="{{(isset($eleve->userId)) ? $eleve->userId : $eleve->id}}">
                                                    Supprimer
                                                </button>
                                                <div class="modal fade" id="deleteEleve">
                                                    <form id="deleteForm" class="form-horizontal" action="/admin/eleve/{{(isset($eleve->userId)) ? $eleve->userId : $eleve->id}}"  method="POST">
                                                        {{csrf_field()}}
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                        <span class="glyphicon glyphicon-remove"></span>
                                                                    </button>
                                                                    <h4 class="modal-title custom_align" id="Heading">Supprimer un élève</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="alert alert-danger"> Voulez-vous vraiment supprimer cet élève?</div>
                                                                    <input type='hidden' name="_method" value='DELETE'>
                                                                </div>
                                                                <div class="modal-footer ">
                                                                    <button type="button" class="btn btn-danger" id="deleteEleveBtn" >Supprimer l'élève</button>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
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
                                                                <h4 class="modal-title custom_align" id="Heading">Supression multiple d'articles</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="alert alert-danger"> Voulez-vous vraiment supprimer les articles cochés?</div>
                                                            </div>
                                                            <div class="modal-footer ">
                                                                <button type="button" id='deleteManyBtn' class="btn btn-danger" >Valider la suppression</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm">
                                                        <span class=" icon-remove-circle" aria-hidden="true"></span>
                                                        <div class="modal-content">
                                                            <h4>Suppression</h4>
                                                            <hr>
                                                            <h4> voulez-vous vraiment supprimer cet article?</h4>
                                                            <input class="btn btn--modal--suppression " type="supprimer" value="supprimer">
                                                            <input class="btn btn-default btn-annuler" type="submit" value="annuler">
                                                        </div>
                                                    </div>
                                                </div><!-- ./End.Modal -->
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>Il n'y a aucun post à administrer</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class='row'>
                        <div class="col-md-6 pull-left">
                            {!! $eleves->appends(['sortBy' => $sortBy, 'sortDir' => $sortDir])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection