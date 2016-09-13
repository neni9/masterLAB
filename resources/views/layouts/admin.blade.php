<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
        <title>ELycée.Lab- @yield('title')</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="viewport" content="height=device-height">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{url('assets/css/back.min.css')}}" media="all">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	 	
	 	<script src="/assets/js/jquery.min.js"></script>
	 	<script src="http://code.highcharts.com/highcharts.js"></script>
	 	<script src="http://code.highcharts.com/highcharts-more.js"></script>
		<script src="http://code.highcharts.com/modules/solid-gauge.js"></script>
		

		@yield('head')
	</head>

	<body>
		
		@include('back.partials.nav')
		@include('back.partials.sidebar') 

		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">	
			 @yield('content')
		</div>
		
        <script src="/assets/js/ckeditor/ckeditor.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
		<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
        <script src="/assets/js/admin.min.js"></script>
        <script src="/assets/js/eleve.min.js"></script>
		<script src="/js/lab.glyphs.js"></script>	
		@yield('scripts')	
	</body>
</html>

