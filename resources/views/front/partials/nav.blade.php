<!-- MAIN NAVBAR -->
<nav class="navbar navbar-default main-nav p">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed mobile-menu" data-toggle="collapse" data-target="#menu-collapse" aria-expanded="false">
                <span>Menu</span>
            </button>
            <a href="/" class="navbar-brand" title="Retourner à la page d'acceuil du site">
                <img src="/images/brand-nav.png" class="img-responsive" alt="Logo Elycee.lab">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="menu-collapse">
            <ul class="nav navbar-nav nav-user-top navbar-right">
                <li class="hidden-sm hidden-md hidden-lg">
                    <a href="/">Home</a>
                </li>
                <li class="hidden-sm hidden-md hidden-lg">
                    <a href="/actualites">Actualités</a>
                </li>
                <li class="hidden-sm hidden-md hidden-lg">
                    <a href="/lycee">Le Lycée</a>
                </li>   
                <li>
                    <a href="https://www.facebook.com/lecolemultimedia" title="Aller sur la page Facebook de Elycee.lab" target=’_blank’>
                        <i class="sprite sprite-facebook"></i>
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/elyceelab" title="Aller sur la page Twitter de Elycee.lab" target=’_blank’>
                        <i class="sprite sprite-twitter"></i>
                    </a>
                </li>
            @if ( auth()->check())
                <li class="nav--user">
                    <a href="#"> 
                        <i class="fa fa-user" aria-hidden="true"></i>
                        {{auth()->user()->first_name}}   {{auth()->user()->last_name}}
                    </a>
                </li>
            @if ( auth()->user()->isAdmin())
                <li class="espace-user-admin">
                    <a href="/admin">Espace admin<i class="fa fa-lock" aria-hidden="true"></i></a>
                </li>
            @elseif ( auth()->user()->isStudent())
                <li class="espace-user-eleve">
                    <a href="/eleve">Espace élève<i class="fa fa-lock" aria-hidden="true"></i></a>
                </li>
            @endif
                <li>
                    <a href="/logout" title="Se déconnecter de Elycee.lab" class="navbar-brand pull-right"><i class="fa fa-2x fa-sign-out" aria-hidden="true"></i></a>
                </li>
            @else 
                <li>
                    <a href="/login" title="Aller sur la page de connexion du site Elycee.lab">
                        <button type="button" class="btn btn-nav btn-dark-nav">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Connexion
                        </button>
                    </a>
                </li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>