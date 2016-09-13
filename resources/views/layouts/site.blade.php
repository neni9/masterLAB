<!DOCTYPE html>
<html class="no-js" lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>ELycée.Lab- @yield('title')</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="viewport" content="height=device-height">
        
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css" media="all">
        <link rel="stylesheet" href="/assets/css/site.min.css" media="all">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="icon" type="image/png" href="/images/favicon-16x16.png" />

        @yield('head')
    </head>
    <body>
       
        @include('front.partials.nav')
        @include('front.partials.header')
        @include('front.partials.subnav')
     
        <div id="main" role="main">

            @if( !call_user_func_array('Request::is', ['lycee','mentions']))
                 <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12">
                     @yield('content')
                </div>
                <div class="col-md-3 col-xs-12 col-sm-12">
                    @section('sidebar')
                        @include('front.partials.sidebar')
                    @show
                </div>
            @else 
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                    @yield('content')
                </div>
            @endif
          
        </div>

        @include('front.partials.footer')

        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/site.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/validation.js"></script>
        <script src="/assets/js/masonry.min.js"></script>


    </body>
</html>