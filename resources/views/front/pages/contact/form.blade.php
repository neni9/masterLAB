    <div class="container-fluid">
        <div class="section">
            <div class="row">
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <h3 class="title text-center ">Contactez nous</h3>

                     @include('general.messages') 


                    <form class="form-horizontal" id='contact-form' role="form" method="post" action="{{url('sendContact')}}">
                    {{csrf_field()}}

                       @if($errors->has())
                           @foreach ($errors->all() as $error)
                              <div class="alert alert-danger">{{ $error }}</div>
                          @endforeach
                        @endif
                        
                        <div class='js-errors'></div>

                         <div class="row m-bottom top-row">
                            <div class="col-md-5 content">
                                <span class="input input--lab">
                                    <input type="text" class="input__field input__field--lab" name="nom" placeholder="Entrez votre nom" value="{{old('nom')}}" required>
                                    <label class="input__label input__label--lab" for="nom">
                                        <span class="input__label-content input__label-sujet--lab">Votre Nom *</span>
                                    </label>
                                   
                                </span>
                            </div>
                            <div class="hidden-xs col-md-1 content"></div>
                            <div class="col-md-5 content">
                                <span class="input input--lab">
                                    <input type="text" class="input__field input__field--lab" name="prenom" placeholder="Entrez votre prénom" value="{{old('prenom')}}" required>
                                    <label class="input__label input__label--lab" for="prenom">
                                        <span class="input__label-content input__label-sujet--lab">Votre Prénom *</span>
                                    </label>
                                    
                                </span>
                            </div>
                        </div>

                        <div class="row m-bottom top-row">
                            <div class="col-md-5 content">
                                <span class="input input--lab">
                                    <input type="email" class="input__field input__field--lab" name="email" placeholder="Entrez votre adresse mail" value="{{old('email')}}" required>
                                    <label class="input__label input__label--lab" for="email">
                                        <span class="input__label-content input__label-sujet--lab">Votre Email *</span>
                                    </label>
                                    
                                </span>
                            </div>
                            <div class="col-md-1 content"></div>
                            <div class="col-md-6 content">
                                <span class="input input--lab">
                                    <input type="text" class="input__field input__field--lab" name="sujet" placeholder="Entrez votre sujet" value="{{old('sujet')}}" required>
                                    <label class="input__label input__label--lab" for="sujet">
                                        <span class="input__label-content input__label-sujet--lab">Sujet *</span>
                                    </label>
                                   
                                </span>
                            </div>
                        </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="input--lab" for="message">Votre message *</label>
                            <textarea class="form--lab--textarea" rows="10" name="message" required>{{old('message')}}</textarea>
                           
                        </div>
                    </div>

                    <div class="row  m-bottom">
                        <span class="input input--lab">
                            <label for="captcha"> Veuillez valider le captcha :</label>
                            {!! app('captcha')->display(); !!}
                           
                        </span>
                    </div>

                    <div class="row m-bottom">
                        <div class="col-md-4 col-md-offset-4 text-center">
                            <button class="btn btn-dark btn-raised">
                                Envoyer
                            </button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

