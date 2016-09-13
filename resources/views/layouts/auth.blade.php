<!DOCTYPE HTML>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title>ELycée.Lab- @yield('title')</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="viewport" content="height=device-height">

        <!-- CSS -->
        <link rel="stylesheet" href="/assets/css/site.min.css" media="all">
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css" media="all">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,600,700,800' rel='stylesheet' type='text/css'>
    </head>

    <body class="body-log">

        @include('auth.partials.nav')
        @yield('content')

        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/validation.js"></script>

    </body>

</html>