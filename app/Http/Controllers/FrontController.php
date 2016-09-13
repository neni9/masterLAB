<?php

namespace App\Http\Controllers;

use View;
use App\Post;
use Carbon\Carbon;
use App\Http\Requests;
use App\Classes\Akismet;
use Illuminate\Http\Request;
use App\Traits\TraitTwitter;
use App\Http\Requests\ContactRequest;

class FrontController extends Controller
{

    use TraitTwitter;

    /**
     * $paginate 
     * @var integer
     */
    private $paginate = 10;

    /**
     * index - SITE PUBLIC / Page Home
     * @return view
     */
    public function index()
    {
        $title = "Accueil";
        
        $lastPosts = Post::with('user','commentsCount','picture')
                         ->OrderByPublished()
                         ->last(4);

        return view('front.pages.index', compact('title','lastPosts'));
    }

    /**
     * post - SITE PUBLIC / Page Détail d'un article
     * @param  integer $id ID d'un post
     * @return view
     */
    public function post($id)
    {
        $post       = Post::findOrFail($id);
        $post->load('commentsCount');

        $title      = $post->title;

        return view('front.pages.articles.detail', compact('post', 'title'));
    }

    /**
     * actualites - SITE PUBLIC / Page Actualités - liste des articles paginés par mois
     * @param  Request $request 
     * @return view
     */
    public function actualites(Request $request)
    {
        $title = "Actualités";
        $data  = $request->all();

        //C R E A T I ON  P A G I N A T I O N  P O S T S  P A R   M O I S - A N N E E //////////////////
        
        //Récupération du mois et de l'Année du post le plus récent
        $selectMonthOptions = Post::GetSelectByMonth();
        $lastPost  = Post::getLastDatePost();
        $lastMonth = $lastPost->published_at->format('m');
        $lastYear  = $lastPost->published_at->format('Y');

        //Récupération du mois et de l'Année du post le plus ancien
        $firstPost  = Post::getFirstDatePost();
        $firstMonth = $firstPost->published_at->format('m');
        $firstYear  = $firstPost->published_at->format('Y');

        //Si l'utilisateur a utiliser la sélection du mois, on la prend en compte, sinon on prend le MOIS et l'ANNEE du post le plus récent
        $month = !empty($data['month']) ? $data['month'] : $lastMonth;
        $year  = !empty($data['year'])  ? $data['year']  : $lastYear;

        //Création d'une date depuis le Mois et l'Année établit    
        $currentDate = Carbon::createFromDate((int)$year, (int)$month, 1, 'Europe/Paris'); 

        //Création des boutons NEXT et PREVIOUS en fonction du mois et de l'année de la page courante
        //CAS 1 : Dernier MOIS-ANNEE : pas de next
        if($month == $lastMonth && $year == $lastYear)
        {
            $next       =  null;
            $previous   =  $currentDate->copy()->subMonth(1);
        } 
        //CAS 2 : PREMIER MOIS-ANNEE : pas de previous
        else if($month == $firstMonth && $year == $firstYear)
        {
            $next       =  $currentDate->copy()->addMonth(1); 
            $previous   =  null;
        } 
        //CAS 3 : MOIS-ANNEE a cheval : next et previous
        else{
            $next       =  $currentDate->copy()->addMonth(1); 
            $previous   =  $currentDate->copy()->subMonth(1);
        }
        
        //Détermination du mois Suivant et Précédant à afficher
        $nextDisplay =  null;
        $prevDisplay = null;
        if(!is_null($next))     $nextDisplay = sprintf("%s %d", Post::getMonth($next->format('m')),$next->format('Y'));
        if(!is_null($previous)) $prevDisplay = sprintf("%s %d", Post::getMonth($previous->format('m')),$previous->format('Y'));

        //Formattage de la date Mois-Année sélectionné pour affichage
        $displayDate = sprintf("%s %d", Post::getMonth((int)$month),$year);

        //Récupération des articles pour le mois sélectionné
        $posts = Post::month($month,$year,'published');

        return view('front.pages.articles.list', compact('title','posts','displayDate','next','previous','nextDisplay','prevDisplay','selectMonthOptions'));
    }

    /**
     * contact - SITE PUBLIC / Contact page
     * @return view
     */
    public function contact()
    {
        $title = 'Contact';

        return view('front.pages.contact.contact', compact('title'));
    }

    /**
     * sendMailContact - Envoie un mail avec les informations récupérées depuis le formulaire de contact
     * @param ContactRequest $request 
     */
    public function sendMailContact(ContactRequest $request)
    {
        $data            = $request->all();
        $data['content'] = nl2br(strip_tags($data['message'], '<br><br />'));

        \Mail::send('front.pages.contact.mail', $data, function($message) use($data){
            $message->from($data['email'], $data['nom']." ".$data['prenom'])
                    ->replyTo($data['email'], $data['nom']." ".$data['prenom'])
                    ->subject($data['sujet'])
                    ->to(env('MAIL'), env('MAIL_USERNAME'));
        });

        $message = 'Votre message a bien été envoyé et transmis au lycée.';
           
        return redirect('contact')->with('message', $message);
    }

    /**
     * mentions - SITE PUBLIC / Page Statique Mentions légales
     * @return view
     */
    public function mentions()
    {
        $title = 'Mentions légales';

        return view('front.pages.mentions', compact('title'));

    }

    /**
     * lycee - SITE PUBLIC - Page Statique Lycée
     * @return [type] [description]
     */
    public function lycee()
    {
        $title = 'Le Lycée';

        return view('front.pages.lycee',compact('title'));
    }

    /**
     * search - SITE PUBLIC / Rechercher un article sur le site
     * @param  Request $request
     * @return view
     */
    public function search(Request $request)
    {
        $data = $request->all();

        $title      = htmlspecialchars($request['search']);
        $searchTerm = htmlspecialchars($data['search']);

        $posts = Post::with('user')
                        ->published()
                        ->OrderByPublished()
                        ->where('title', 'like','%'.$searchTerm.'%')
                        ->orwhere('content', 'like','%'.$searchTerm.'%')
                        ->paginate($this->paginate);
              
        $total = $posts->count();
                    
        return view('front.pages.search',compact('title','posts','total','searchTerm'));
    }

}
