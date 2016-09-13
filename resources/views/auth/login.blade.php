@extends('layouts.auth')
@section('title', $title)
@section('content') 

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4  panel-log">
            <h3 class="title text-center ">{{$title}}</h3>
            @include('general.messages')

            <form method="POST" action="{{url('login')}}">
                {{csrf_field()}}

                @if($errors->has())
                   @foreach ($errors->all() as $error)
                      <div class="error">{{ $error }}</div>
                  @endforeach
                @endif

                <div class="row content">
                    <div class="col-md-12">
                        <span class="input input--lab">
                            <input type="text" class="input__field input__field--lab" name="login" placeholder="Email ou Nom d'utilisateur" value="{{old('login')}}" required>
                            <label class="input__label input__label--lab" for="input">
                                <span class="input__label-content input__label-content--lab">Identifiant (email ou username)</span>
                            </label>
                        </span>
                    </div>
                    <div class="col-md-12">
                        <span class="input input--lab">
                            <input type="password" class="input__field input__field--lab" name="password" placeholder="Mot de passe" required>
                            <label class="input__label input__label--lab" for="input">
                                <span class="input__label-content input__label-content--lab">Mot de passe</span>
                            </label>
                        </span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="radio">
                        <label>
                            <input id="remember" type="checkbox" name="remember">
                            Se souvenir de moi
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 text-center">
                        <button class="btn btn-dark btn-raised" type="submit">Connexion</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection