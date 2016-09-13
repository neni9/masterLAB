<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                <img src="/images/brand-nav.png" class="img-responsive" alt="Logo Elycee.lab">
            </a>
            <ul class="user-menu">
                <li class='pull-left'>
                     <a href="/"> <i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
                </li>
            </ul>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <svg class="glyph stroked male-user">
                            <use xlink:href="#stroked-male-user"></use>
                        </svg> 
                        @if(auth()->check())
                            <span class="hidden-xs">Bienvenue {{auth()->user()->first_name}}   {{auth()->user()->last_name}}</span>
                        @else 
                            Utilisateur
                        @endif
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="/logout">
                                <svg class="glyph stroked cancel">
                                    <use xlink:href="#stroked-cancel"></use>
                                </svg> Déconnexion
                            </a>
                        </li>
                    </ul>
                </li>  
            </ul>
        </div><!-- /.navbar-header -->                
    </div><!-- /.container-fluid -->
</nav>