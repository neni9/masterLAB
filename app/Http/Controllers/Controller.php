<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use View;
use App\Post;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


    public function __construct(){
	    View::composer(['front.partials.sidebar'],function($view){

	    	//Informations de la sidebar : Les 3 posts les plus commentés et les 5 derniers tweets
            $topPosts = Post::top(3);
            $tweets = $this->getTweets(5);

	        $view->with(compact('topPosts','tweets'));
	        
	    });
	}


}
