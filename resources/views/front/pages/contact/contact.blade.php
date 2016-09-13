@extends('layouts.site')
@section('title', $title)
@section('content') 

    <div class="container">
	    <div class='row'> 
	        <h2>Contact Lycée</h2>
	    </div>
	    <!-- FORM CONTACT  -->
		<div class="form">
			@include('front.pages.contact.form')
		</div>
	</div>

@endsection