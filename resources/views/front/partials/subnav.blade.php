<nav class="navbar navbar-content hidden-xs " id='sub-nav'>
    <div class="container-fluid">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="/">Home</a></li>
                <li><a href="/actualites">Actualités</a></li>
                <li><a href="/lycee">Le Lycée</a></li>
            </ul>
            <form class="navbar-form  navbar-right" role="search" method="post" action="{{url('/search')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    <input type="text" required name="search" class="form-control form-search" placeholder="Rechercher un article">
                </div>
                <button type="submit" class="btn btn-dark-nav">Envoyer</button>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>