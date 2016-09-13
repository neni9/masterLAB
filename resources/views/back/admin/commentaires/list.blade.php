@extends('layouts.admin')
@section('title', $title)
@section('content')

 <div class="container-fluid">
     <div class="col-xs-12 main">
        <div class="row">
            <h2>{{$title}} <small>Valid ({{$total['valid']}}), Spam ({{$total['spam']}}), Non vérifié ({{$total['unchecked']}}) </small> </h2>
            <div class="container-fluid panel panel-back">
                <div class="container-fluid">

                    <form id='sort-form' method="get" action="/comment">
                        <input type="hidden" name="sortBy" value="{{$sortBy}}">
                        <input type="hidden" name="sortDir" value="{{$sortDir}}">
                        <button type="submit" style='display:none;'>Valider</button>
                    </form>

                    <form class="form-inline" id='massupdate-form' method="post" action="admin/commentMassupdate">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-md-12">
                            <h4 class="row-top"> Séléctionnez l'action souhaitée (Appliquer à tous les éléments cochés) </h4>
                                <div class="form-group col-md-6 ">
                                     <select name="massupdate" class="form-admin-input" required>
                                        <option value="0"></option>
                                        <option value="validAndPublished">Valider et publier les commentaires</option>
                                        <option value="delete">Supprimer les commentaires</option>
                                  </select>
                                </div>
                                <button type='submit' id='massupdateBtn' class='btn btn-dark'>Appliquer</button>
                            </div>
                        </div>

                        <div class="row">
                            @include('general.messages') 
                        </div>
    
                        <div class='row commentBlock'>
                            <table class="table table-hover table-condensed custome--lab--table table-responsive">
                                <thead>
                                    <tr>
                                        <th class="label--table">
                                            <input type='checkbox' name='checkall'>
                                        </th>
                                        <th class="label--table">
                                            Pseudo <i class="fa fa-sort" id='pseudo' aria-hidden="true"></i>
                                        </th>
                                        <th class="label--table">
                                            Contenu du commentaire <i class="fa fa-sort" id='content' aria-hidden="true"></i>
                                        </th>
                                        <th class="label--table">
                                            Type <i class="fa fa-sort" id='type' aria-hidden="true"></i>
                                        </th>
                                        <th class="label--table">
                                            Statut <i class="fa fa-sort" id='status' aria-hidden="true"></i>
                                        </th>
                                        <th class="label--table">
                                            Posté le <i class="fa fa-sort" id='created_at' aria-hidden="true"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($comments as $comment)
                                    <tr class='{{$comment->id}}'>
                                        <td>
                                            <input type='checkbox' name='ids[]' value='{{$comment->id}}'>
                                        </td>
                                        <td>
                                            {{$comment->pseudo}}
                                        </td>
                                        <td class='text-justify commentCol {{strtolower($comment->type)}}'>
                                            <u>Titre : {{$comment->title}}</u> 
                                            <br>
                                            <i>{{$comment->content}}</i>
                                            <br>
                                            <b>Relatif à l'article : <a href="{{url('/article/'.$comment->post->id)}}">{{$comment->post->title}}</a></b>
                                        </td>
                                        <td class='text-center'>
                                        @if($comment->type == 'Valide')
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        @elseif($comment->type == 'Spam')
                                            <i class="fa fa-ban" aria-hidden="true"></i>
                                        @else 
                                            <i class="fa fa-question" aria-hidden="true"></i>
                                        @endif
                                        </td>
                                        <td> 
                                            {{$comment->status }} 
                                        </td>
                                        <td> 
                                            {{ (!is_null($comment->created_at)) ? $comment->created_at->format('d/m/Y') : 'NC'}} 
                                        </td>
                                    </tr>
                                    @empty
                                    <p>Il n'y a aucun post à administrer.</p>
                                    @endforelse
                                </tbody>
                            </table>
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
                                <h4 class="modal-title custom_align" id="Heading">Supression multiple de commentaires</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger"> Voulez-vous vraiment supprimer les commentaires sélectionnés?</div>
                            </div>
                            <div class="modal-footer ">
                                <button type="button" id='deleteManyBtn' class="btn btn-danger" >Valider la suppression</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class="col-md-6 pull-left">
                        {!! $comments->appends(['sortBy' => $sortBy, 'sortDir' => $sortDir])->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection