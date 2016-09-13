@extends('layouts.admin')
@section('title', $title)
@section('content')

<div class="container-fluid">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">
        <div class="row">
            <h2>{{$title}}</h2>
            <div class="panel panel-back">
                <div class="container-fluid">

                    <div class="row top-row">
                        @include('general.messages') 
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1">
                            <div class="row js-errors alert-danger"></div>
                        </div>
                    </div>
                @if (isset($post->id))
                    <form method="POST" id="post-form" action="{{url('admin/post/'.$post->id)}}" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                @else 
                    <form method="POST"  id="post-form"  action="{{url('admin/post')}}" enctype="multipart/form-data">
                @endif
                        {{csrf_field()}}

                        <div class="row top-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="title" class="input--lab--admin">Titre *</label>
                                        <input type="text" name="title" class="form-admin-input required" value="{{old('title',isset($post->title) ? $post->title : null)}}">
                                        @if($errors->has('title')) <span class="error">{{$errors->first('title')}} </span>@endif 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="input--lab--admin">Statut *</label>
                                    <select name='status'  class="form-admin-input required" >
                                        <option value="published"
                                            @if (isset($post->status) && $post->status == 'Publié')
                                            selected
                                            @endif
                                        >Publié</option>
                                        <option value="unpublished"
                                            @if (isset($post->status) && $post->status == 'Non Publié')
                                            selected
                                            @endif
                                        >Non Publié</option>
                                    </select>
                                    @if($errors->has('status')) <span class="error">{{$errors->first('status')}} </span>@endif 
                                </div>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="input--lab--admin">Nom de l'image</label>
                                    <input type="text" name="picture_name" class="form-admin-input" value="{{old('picture_name',isset($post->picture) ? $post->picture->name : null)}}">
                                    @if($errors->has('picture_name')) <span class="error">{{$errors->first('picture_name')}} </span>@endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="picture" class="input--lab--admin">
                                        @if(isset($post->picture))
                                        Remplacer l'image par une nouvelle 
                                        @else 
                                        Lier une image à cet article 
                                        @endif
                                    </label>
                                    <input type="file" name="picture" class="form-admin-input" value="{{old('picture',isset($post->picture) ? $post->picture : null)}}">
                                    @if($errors->has('picture')) <span class="error">{{$errors->first('picture')}} </span>@endif
                                </div>
                            </div>
                        </div>

                        @if(isset($post->picture))
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                                <div class="row">
                                    <p class='text-center'><strong>Image actuelle :</strong></p>
                                    <img class='img-responsive img-center' src="/uploads/{{$post->picture->uri}}">
                                </div>
                                <div class="row text-center">
                                    <label for="deleteImage" class="input--lab--admin">Supprimer l'image ? Oui </label>
                                    <input type="checkbox" name="deleteImage">
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group content-area">
                                    <label for="excerpt" class="input--lab--admin">Extrait</label>
                                    <textarea name="excerpt"  class="form-admin-texterea text-left" rows="3" >{{old('excerpt',isset($post->excerpt) ? $post->excerpt : null)}}</textarea>
                                    @if($errors->has('excerpt')) <span class="error">{{$errors->first('excerpt')}} </span>@endif
                                </div>

                                <div class="form-group content-area">
                                    <label for="content" class="input--lab--admin" id="labelcontenu">Contenu *</label>
                                    <textarea id='content' name="content"  class="form-admin-input ckeditor" rows="15" >{{old('content',isset($post->content) ? $post->content : null)}}</textarea>
                                    @if($errors->has('content')) <span class="error">{{$errors->first('content')}}</span>@endif
                                    <span id="contentError" class='nodisplay error'>Le contenu n'est pas valide : le champ est obligatoire et le nombre de caractères doit être supérieur ou égale à 20.</span>
                                </div>
                            </div>
                        </div>

                        @if(!isset($post))
                        <div class="row">
                            <div class='col-md-12'>
                                <input type="checkbox" name="tweet">
                                <label for="tweet" class="input--lab--admin">Poster un tweet automatique pour la publication de cet article? </label> 
                                <div class="tweet_form">
                                    <hr>
                                    <label for="tweet_content" class="input--lab--admin">Contenu du Tweet (100 caractères maximum)</label>
                                    <textarea id='tweet_content' name="tweet_content"  class="form-admin-input" rows="3" ></textarea>
                                    <br>
                                    <span id="tweetError" class='nodisplay error'>Le texte du tweet ne doit pas dépasser 100 caractères.</span>
                                    <input type="checkbox" name="tweet_img">
                                    <label for="tweet_img" class="input--lab--admin">Inclure l'image de l'article dans le tweet s'il y en a une</label>
                                    <div class="row">
                                        <div class='col-md-11'>
                                            <div class="alert alert-info">
                                                Remarque : Si vous laissez le contenu du tweet vide, un message automatique sera utilisé : Retrouvez un nouvel article sur notre site  : NOM ARTICLE.
                                                <br>
                                                Dans les deux cas, un lien vers l'article sera ajouté au tweet.
                                            </div>
                                        </div>
                                        <div class='col-md-1'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row top-row">
                            <div class="col-md-12">
                                <button class='btn btn-large btn-block btn-dark full-width' id="postSubmit" type='button'>
                                    @if (isset($post->id))
                                    Editer l'article
                                    @else 
                                    Créer l'article
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection