<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\Comment;
use App\Http\Requests;
use App\Classes\Akismet;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;

class CommentController extends Controller
{

   /**
     * $paginate (25 par page)
     * 
     * @var integer
     */
    private $paginate = 25;

    /**
     * $sortBy orderBy default field
     * 
     * @var string
     */
    private $sortBy   = 'created_at';

    /**
     * $sortDir orderDir default desc
     * 
     * @var integer
    */
    private $sortDir  = 'desc';

    /**
     * __construct 
     * 
     */
    public function __construct(){}

    /**
     * index : Liste des commentaires PARTIE ADMIN
     * @param  CookieJar $cookie  - Pour garder en cookie le tri des colonnes de l'utilisateur
     * @param  Request   $request 
     * @return view 
     */
    public function index(CookieJar $cookie, Request $request)
    {
        $title  = 'Liste des commentaires';
        $data   = $request->all();

        //Récupération SORTBY
        if(empty($request->cookie('elycee_comment_sortby')))
            $sortBy = $this->sortBy;
        else{
            if(!empty($data['sortBy'])) $sortBy  = $data['sortBy'];
            else                        $sortBy  = $request->cookie('elycee_comment_sortby');
        }

        //Récupération SORTDIR
        if(empty($request->cookie('elycee_comment_sortdir')))
            $sortDir = $this->sortDir;
        else{
            if(!empty($data['sortDir'])) $sortDir  = $data['sortDir'];
            else                         $sortDir  = $request->cookie('elycee_comment_sortdir');
        }

        $comments = Comment::getCommentsBySort($sortBy,$sortDir);
        
        $total                = [];
        $total['spam']          = Comment::where('type','=','spam')->count();
        $total['valid']         = Comment::where('type','=','valid')->count();
        $total['unchecked']     = Comment::where('type','=','unchecked')->count();

        if(!empty($sortBy))  $cookie->queue(cookie('elycee_comment_sortby', $sortBy, 45000));
        if(!empty($sortDir)) $cookie->queue(cookie('elycee_comment_sortdir', $sortDir, 45000));
         
        return view('back.admin.commentaires.list',compact('comments','title','total','sortBy','sortDir'));
    }

    /**
     * commentMassUpdate - Mise à jour globale des commentaires
     * @param  Request $request 
     * @return view
     */
    public function commentMassUpdate(Request $request)
    {
        $datas = $request->all();   

        if(empty($datas['massupdate']) || empty($datas['ids']) ) return redirect('/comment')->with('message', sprintf('Erreur dans la récupération des données'));

        if($datas['massupdate'] == 'validAndPublished' ){

            $comments = Comment::whereIn('id', $datas['ids'])->get();

            foreach ($comments as $comment ) {
              
                $comment->type       = 'valid';
                $comment->status     = 'published';
                $comment->save();
            }

            return redirect('/comment')->with('message', sprintf('La mise à jour globale des commentaires a été effectuée avec succès.'));
        }
        else if($datas['massupdate'] == 'delete'){
            $delete = $this->destroyMany($datas['ids']); 

            if($delete)
                return redirect('/comment')->with('message', sprintf("Les commentaires ont bien été supprimés."));
            else
                return redirect('/comment')->with('message', sprintf("Erreur lors de la suppression des éléments."));
        }
    }

    /**
     * destroyMany - Supprime plusieurs commentaires
     * @param  integer $ids commentaire ID
     * @return boolean
     */
    public function destroyMany($ids)
    {
        if(!is_array($ids)) return;

        Comment::whereIn('id', $ids)->delete();
        
        return true;
    }


     /**
     * Supprime le commentaire dont l'id est passé en paramètre
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment  = Comment::findOrFail($id);
        $title = $comment->title;
        
        $comment->delete();
        
        return redirect('/comment')->with('message', sprintf("Le commentaire a bien été supprimé.",$title));
    }

    /**
     * Insert un nouveau commentaire dans la base de données 
     * et vérifie avec le filtre anti spam Akismet si c'est un spam ou non pour remplir le type du commentaire
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = $request->all();

        $apiKey   = env('AKISMET_KEY'); // 40fbac2de230
        $siteURL  = env('APP_URL'); //'localhost';
        $akismet  = new Akismet($siteURL,$apiKey);
        $type     = 'unchecked';

        if ($akismet->isKeyValid()) {

            $akismet->setCommentAuthor($datas['pseudo']);
            $akismet->setCommentContent($datas['content']);
            $akismet->setPermalink('localhost/article/'.$request->post_id);
    
            if($akismet->isCommentSpam())
                $type = 'spam';
            else
                $type = 'valid';
        }

         $comment           = Comment::create($datas);
         $comment->type     = $type;
         $comment->status   = 'unpublished';

         if(isset($request->identity) &&$request->identity == "on"){
            $comment->user_id     = Auth()->user()->id;
            $comment->pseudo      = sprintf("%s %s",Auth()->user()->first_name,Auth()->user()->last_name);
         }
         
         $comment->save();

        return redirect("article/".$request->post_id)->with('message', sprintf("Merci ! Votre commentaire va être soumis à approbation."));
    }


}