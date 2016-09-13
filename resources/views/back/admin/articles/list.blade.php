@extends('layouts.admin')
@section('title', $title)
@section('content')

<div class="container-fluid">
    <div class="col-xs-12 main">
        <div class="row">
            <h2>
                {{$title}} 
                <small>Publié ({{$total['published']}}), Non Publié ({{$total['unpublished']}}) </small>  
            </h2>
           
            <div class="container-fluid panel panel-back">
                <div class="container-fluid">

                    <form id='sort-form' method="get" action="/admin/post">
                        <input type="hidden" name="sortBy" value="{{$sortBy}}">
                        <input type="hidden" name="sortDir" value="{{$sortDir}}">
                        <button type="submit" class="nodisplay">Valider</button>
                    </form>
                    
                    <form class="form-inline top-row" id='massupdate-form' method="post" action="/admin/postMassupdate">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="row-top"> Séléctionnez l'action souhaitée (Appliquer à tous les éléments cochés)</h4>
                                <div class="form-group col-md-6">
                                     <select name="massupdate" class="form-admin-input" required>
                                         <option value="0"></option>
                                        <option value="published">Publié</option>
                                        <option value="unpublished">Non Publié</option>
                                        <option value="delete">Supprimer</option>
                                  </select>
                                </div>
                                    <button type='submit' id='massupdateBtn' class='btn btn-dark'>Appliquer</button>
                                    <a href="/admin/post/create">
                                        <button type='button' class='btn btn--modal--edit navbar-right'>Ajouter un article</button>
                                    </a>
                            </div>
                        </div>

                        <div class="row">
                            @include('general.messages') 
                        </div>
                
                        <table class="table table-hover table-condensed custome--lab--table table-responsive">
                            <thead>
                                <tr>
                                    <th class="label--table">
                                        <input type='checkbox' name='checkall'>
                                    </th>
                                    <th class="label--table">
                                        Titre 
                                        <i class="fa fa-sort" id='title' aria-hidden="true"></i>
                                    </th>
                                    <th class="label--table">
                                        Auteur 
                                        <i class="fa fa-sort" id='first_name' aria-hidden="true"></i>
                                    </th>
                                    <th class="label--table">
                                        Publié lé 
                                        <i class="fa fa-sort" id='published_at' aria-hidden="true"></i>
                                    </th>
                                    <th class="label--table">
                                        <i class="fa fa-comment" aria-hidden="true" title="Commentaires"></i>  
                                        <i class="fa fa-sort" id='comments' aria-hidden="true"></i>
                                    </th>
                                    <th class="label--table">
                                        Statut  
                                        <i class="fa fa-sort" id='status' aria-hidden="true"></i>
                                    </th>
                                    <th class='text-center button-control label--table'> 
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $post)
                                <tr class='{{$post->id}}'>
                                    <td>
                                        <input type='checkbox' name='ids[]' value='{{$post->id}}'>
                                    </td>
                                    <td>
                                        <a href="/admin/post/{{$post->id}}/edit" class="linkTitle">{{$post->title}}</a>
                                    </td>
                                    <td>
                                        {{$post->user ? $post->user->first_name.' '.$post->user->last_name : 'Aucun auteur'}}
                                    </td>
                                    <td>
                                        {{!is_null($post->published_at) ? $post->published_at->format('d/m/Y') : 'NC'}}
                                    </td>
                                    <td>
                                        {{$post->comments->count()}}
                                    </td>
                                    <td class='text-center' >
                                        <i class="fa fa-square {{$post->status == 'Publié' ? 'success' : 'default' }}" aria-hidden="true"></i>
                                    </td>
                                    <td class='text-center button-control' >
                                        <a href="/admin/post/{{$post->id}}/edit">
                                            <button type="button" class="btn btn--modal--edit btn-bottom" >Editer</button>
                                        </a>
                                        <button type="button" class="btn btn--modal--suppression btn-bottom deleteBtn" data-toggle="modal" data-target="#deletePost" data-id="{{$post->id}}">
                                            Supprimer
                                        </button>
                                        <div class="modal fade" id="deletePost">
                                            <form id="deleteForm" class="form-horizontal" action="/admin/post/{{$post->id}}"  method="POST">
                                                {{csrf_field()}}
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                            </button>
                                                            <h4 class="modal-title custom_align" id="Heading">Supprimer un article</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger"> Voulez-vous vraiment supprimer cet article?</div>
                                                            <input type='hidden' name="_method" value='DELETE'>
                                                        </div>
                                                        <div class="modal-footer ">
                                                            <button type="button" class="btn btn-danger" id="deletePostBtn" >Supprimer l'article</button>
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Il n'y a aucun article à administrer.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class='row'>
                <div class="col-md-6 pull-left">
                    {!! $posts->appends(['sortBy' => $sortBy, 'sortDir' => $sortDir])->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection