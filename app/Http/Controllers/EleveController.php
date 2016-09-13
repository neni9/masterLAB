<?php

namespace App\Http\Controllers;

use DB;
use View;
use App\User;
use App\Score;
use App\Question;
use Carbon\Carbon;
use App\Class_level;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;

class EleveController extends Controller
{
    /**
     * $paginate (10 élèves par page)
     * 
     * @var integer
     */
    private $paginate = 10;

    /**
     * $sortBy default
     * @var string
     */
    private $sortBy   = 'first_name';

      /**
     * $sortDir default
     * @var string
     */
    private $sortDir  = 'asc';

    /**
     * __construct 
     * 
     */
    public function __construct(){}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CookieJar $cookie, Request $request)
    {

        $title = 'Liste des élèves';
        $data  = $request->all();

        //Récupération SORTBY
        if(empty($request->cookie('elycee_eleves_sortby')))
            $sortBy = $this->sortBy;
        else{
            if(!empty($data['sortBy'])) $sortBy  = $data['sortBy'];
            else                        $sortBy  = $request->cookie('elycee_eleves_sortby');
        }

        //Récupération SORTDIR
        if(empty($request->cookie('elycee_eleves_sortby')))
            $sortDir = $this->sortBy;
        else{
            if(!empty($data['sortDir'])) $sortDir  = $data['sortDir'];
            else                         $sortDir  = $request->cookie('elycee_eleves_sortby');
        }

        $eleves         = User::getElevesBySort($sortBy,$sortDir);
        $classlevels    = Class_level::all();

        $total                  = [];
        $total['first_class']   = User::where('class_level_id','=',1)->count();
        $total['last_class']    = User::where('class_level_id','=',2)->count();

        if(!empty($sortBy))  $cookie->queue(cookie('elycee_eleves_sortby', $sortBy, 45000));
        if(!empty($sortDir)) $cookie->queue(cookie('elycee_eleves_sortdir', $sortDir, 45000));
         
        // dd($eleves);
        return view('back.admin.eleves.list',compact('eleves','classlevels','title','total','sortBy','sortDir'));
    }

    /**
     * eleveMassUpdate - Mise à jour globale des élèves
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function eleveMassUpdate(Request $request)
    {
        $datas = $request->all();   

        if(empty($datas['massupdate']) || empty($datas['ids']) ) return redirect('/admin/eleve')->with('messages',  sprintf('Erreur lors de la récupération des données.'));

        $action = explode('&',$datas['massupdate']);

        switch ($action[0]) {
            //Cas 1 : Suppression d'un élève
            case 'delete':

                $delete = $this->destroyMany($datas['ids']); 

                if($delete)
                     $messages = sprintf("Les élèves ont bien été supprimés.");
                else
                     $messages = sprintf("Erreur lors de la suppression des éléments.");
            
                break;  
            //CAS 2 : Changement du statut de l'élève
            case 'status': 

                $field = explode('&',$datas['massupdate']);
                User::whereIn('id', $datas['ids'])->update([$field[0] => $field[1]]);

                $messages = sprintf("La mise à jour des élèves a été effectuée avec succès.");

                break;

            //CAS 3 : Changement de classe de l'élève
            case 'class_level_id':

                $messages = [];
                $field = explode('&',$datas['massupdate']);
   
                //Récupération de toutes les questions liées à la nouvelle classe
                $questions = Question::select('id')
                                       ->where('status','published')
                                       ->where('class_level_id',$field[1])->get();

                $usersSelected = User::whereIn('id',$datas['ids'])->get();
                //Tour de chaque ID d'élève cochés dans le tableau
                foreach ($usersSelected as $user) {
              
                    //Si l'élève est déjà dans la classe, on return
                    if((int)$user->class_level_id === (int)$field[1]) {
                       
                        $messages[] = sprintf("%s %s est déjà dans cette classe.",$user->first_name,$user->last_name);
                        continue;
                    }

                    //Sinon on supprime tous ces scores Non fait 
                    Score::where('user_id',$user->id)
                          ->where('status_question','notdone')
                          ->delete();

                    //Récupération des scores restants lié à l'élève
                    $scores = Score::where('user_id',$user->id)->get();
                    
                    //Détermination d'une liste d'ID a exclure lorque l'on va crée les nouveaux scores pour les questions de la nouvelle classe
                    $excluIds = [];
                    foreach ($scores as $score) 
                        $excluIds[] = $score->question_id;
                     
                    //Création des datas à insérer dans la table score
                    $insert = []; 
                    foreach ($questions as $question) {
                        if(!in_array($question->id,$excluIds))
                            $insert[] = ['user_id' => $user->id, 'question_id' => $question->id];
                    }
                    
                    //Insertion des nouveaux scores
                    Score::insert($insert);

                    //Mise à jour de l'utilisateur avec la nouvelle classe
                    User::whereIn('id', $datas['ids'])->update([$field[0] => $field[1]]);

                    $messages[] = sprintf("La mise à jour de l'élève %s %s a été effectuée avec succès.",$user->first_name,$user->last_name);

                }
                break;
            default:
                $messages = "Erreur : Action inconnue.";
                break;
        }

        return redirect('/admin/eleve')->with('message', $messages);
    }

    /**
     * Supprimer plusieurs élèves à la fois
     *
     * @param  array $id
     * @return boolean
     */
    public function destroyMany($ids)
    {
        if(!is_array($ids)) return;
        
        User::whereIn('id', $ids)->delete();
        
        return true;
    }

    /**
     * Supprimer un élève en fonction de son ID utilisateur passé en paramètre
     *
     * @param  int $id
     * @return redirect
     */
    public function destroy($id)
    {
        $user  = User::findOrFail($id);
        
        $user->delete();
        
        return redirect('/admin/eleve')->with('message', sprintf("L'élève %s a bien été supprimé avec succès.",$user->first_name." ".$user->last_name));
    }
}
