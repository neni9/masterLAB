<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	/**
	 * login method for all users
	 * 
	 * @param  Request $request 
	 * @return response        
	 */
    public function login(Request $request){

    	if($request->isMethod('post')){

    		//Détermination si l'utilisateur essaie de se connecter par email ou pas username
    		$field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    		$request->merge([$field => $request->input('login')]);
    	
    		//Validation dans le cas d'un mail
    		if($field == 'email'){
	    		$this->validate($request, [
	            	'email'    => 'required|email',
		            'password' => 'required',
		            'remember' => 'in:on,off'
		        ]);
		    //Validation dans le cas d'un username
    		}else{
    			$this->validate($request, [
		            'username' => 'required|max:255',
		            'password' => 'required',
		            'remember' => 'in:on,off'
		        ]);
    		}

    		//Se souvenir de moi
    		$remember 	  = ($request->input('remember') == "on") ? true : false;
	        $credentials  = $request->only($field,'password');

	        //Test de la connexion utilisateur et aredirection en fonction
	        if(Auth::attempt($credentials,$remember)){

	        	if(Auth::user()->status == "inatif"){
	        		Auth::logout();
	        		return back()->withInput($request->only('login','remember'));
	        	}

	        	if(Auth::user()->isAdmin())
	        		return redirect('/admin');
	        	else if(Auth::user()->isStudent())
	        		return redirect('/eleve');
	        	else
	        		return redirect('/')->with(['message',sprintf('Bienvenue ')]);
	        }
	        else{
	        	return back()->withInput($request->only('login','remember'))
	        				 ->with(['message' => sprintf("Erreur lors de l'authentification.")]);
	        }

    	}else{
    		
			$title  = "Identifiez-vous";

    		return view('auth.login',compact('title'));
    	}

    }

    /**
     * logout method for connected user
     * 
     * @return redirect
     */
    public function logout(){

    	Auth::logout();
    
    	return redirect('/login')->with(['message' => sprintf("Déconnexion réussie!")]);
    }
}
