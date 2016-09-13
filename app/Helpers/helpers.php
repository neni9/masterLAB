<?php 

use Illuminate\Support\Str;


/**
 * excerpt fonction - Prend les X premiers caractères d'une string pour un extrait
 */
if(!function_exists('excerpt'))
{
	function excerpt($text,$limit = 90, $end='...')
	{
		return Str::words($text,$limit,$end);
	}
}

/**
 * menuActive fonction - Permet de changer la couleur du menu active dans la Sidebar Admin & Eleve
 */
if(!function_exists('menuActive')){
    function menuActive($path, $class = 'active') {
        
        if(auth()->check()){

            if(auth()->user()->isAdmin())
                $class = 'activeAdmin';
            else if(auth()->user()->isStudent())
                $class = 'activeEleve';
        }

        return call_user_func_array('Request::is', (array)$path) ? $class : '';

    }
}