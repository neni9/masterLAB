<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::pattern('id', '[1-9][0-9]*');

Route::group(['middleware' => []], function () {


	Route::get('/', ['as' => 'home', 'uses' => 'FrontController@index']);

	Route::any('lycee', 'FrontController@lycee');
	Route::any('mentions', 'FrontController@mentions');
	Route::any('contact', 'FrontController@contact');
	Route::any('sendContact', 'FrontController@sendMailContact');

	Route::any('login', 'LoginController@login');
	Route::any('logout', 'LoginController@logout');

	Route::get('/article/{id}', 'FrontController@post');
	Route::get('/actualites', 'FrontController@actualites');
	
	Route::any('search', 'FrontController@search');
	
	Route::resource('/comment', 'CommentController');

	Route::group(['middleware' => ['auth']], function () {

		Route::group(['middleware' => ['admin']], function () {
		    Route::resource('/admin/post', 'PostController');
		    Route::resource('/admin/eleve', 'EleveController');
		    Route::resource('/admin/question', 'QuestionController');

		    Route::resource('/comment', 'CommentController', ['only' => ['destroy','update','index']]);

		    Route::get('/admin/choice/{question_id}', 'ChoiceController@createChoices');
		    Route::post('/admin/choice/store', 'ChoiceController@storeChoices');

		    Route::any('/admin', 'DashboardController@admin');

		    Route::any('/admin/postMassupdate','PostController@postMassUpdate');
		    Route::any('/admin/commentMassupdate','CommentController@commentMassUpdate');
		    Route::any('/admin/qcmMassupdate','QuestionController@qcmMassUpdate');
		    Route::any('/admin/eleveMassupdate','EleveController@eleveMassUpdate');

		});

		Route::group(['middleware' => ['eleve']], function () {
		    Route::any('/eleve', 'DashboardController@eleve');
	    	Route::any('/eleve/question', 'QuestionController@eleveIndex');
	    	Route::any('/eleve/question/do/{question_id}', 'QuestionController@doQuestion');
	    	Route::post('/eleve/question/resultat', 'ScoreController@resultat');

		});


	});

	   
});
