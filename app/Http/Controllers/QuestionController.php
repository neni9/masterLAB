<?php

namespace App\Http\Controllers;

use Auth;
use View;
use File;
use App\User;
use App\Score;
use App\Choice;
use App\Picture;
use App\Question;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use App\Http\Requests\QuestionRequest;

class QuestionController extends Controller
{
    /**
     * $paginate (10 posts by pages)
     * 
     * @var integer
     */
    private $paginate = 25;
    private $sortBy   = 'title';
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
        $title = 'Liste des questions';
        $data  = $request->all();

         //Récupération SORTBY
        if(empty($request->cookie('elycee_qcm_sortby')))
            $sortBy = $this->sortBy;
        else{
            if(!empty($data['sortBy'])) $sortBy  = $data['sortBy'];
            else                        $sortBy  = $request->cookie('elycee_qcm_sortby');
        }

        //Récupération SORTDIR
        if(empty($request->cookie('elycee_qcm_sortdir')))
            $sortDir = $this->sortDir;
        else{
            if(!empty($data['sortDir'])) $sortDir  = $data['sortDir'];
            else                         $sortDir  = $request->cookie('elycee_qcm_sortdir');
        }

        //Liste des questions triées
        $questions = Question::getQuestionsOrderBy($sortBy,$sortDir);

        //Liste des questions qui n'ont pas tous leurs choix complétés
        $notCompleted = [];
        foreach ($questions as $question) {
            $id = isset($question->questionId) ? $question->questionId : $question->id;
            $notCompleted[$id] = Choice::where('question_id',$id)
                           ->where('content','<>',"")
                           ->where('content','<>',NULL)
                           ->count();
        }   

        $total              = [];
        $simple             = Question::totalType('simple');
        $multiple           = Question::totalType('multiple');
        $total['simple']    = is_object($simple)   ? 0 : $simple;
        $total['multiple']  = is_object($multiple) ? 0 : $multiple;

        if(!empty($sortBy))  $cookie->queue(cookie('elycee_qcm_sortby', $sortBy, 45000));
        if(!empty($sortDir)) $cookie->queue(cookie('elycee_qcm_sortdir', $sortDir, 45000));
         

        return view('back.admin.questions.list',compact('questions','title','total','sortBy','sortDir','notCompleted'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function eleveIndex(CookieJar $cookie, Request $request)
    {
        $title  = 'Liste des questions';
        $user   = auth()->user();
        $data   = $request->all();

        //Récupération SORTBY
        if(empty($request->cookie('elycee_eleve_questions_sortby')))
            $sortBy = $this->sortBy;
        else{
            if(!empty($data['sortBy'])) $sortBy  = $data['sortBy'];
            else                        $sortBy  = $request->cookie('elycee_eleve_questions_sortby');
        }

        //Récupération SORTDIR
        if(empty($request->cookie('elycee_eleve_questions_sortdir')))
            $sortDir = $this->sortBy;
        else{
            if(!empty($data['sortDir'])) $sortDir  = $data['sortDir'];
            else                         $sortDir  = $request->cookie('elycee_eleve_questions_sortdir');
        }
        //Statistiques
        $total             = [];
        $total['notdone']  = Score::where('user_id',$user->id)
                                    ->where('status_question','notdone')
                                    ->count();

        $total['done']     = Score::where('user_id',$user->id)
                                    ->where('status_question','done')
                                    ->count();
        
        //Récupération des questions publiées liées à l'utilisateur avec leurs scores
        $questions = Question::getQuestionsForUserOrderBy($sortBy,$sortDir,$user->id);

        if(!empty($sortBy))  $cookie->queue(cookie('elycee_eleve_questions_sortby', $sortBy, 45000));
        if(!empty($sortDir)) $cookie->queue(cookie('elycee_eleve_questions_sortdir', $sortDir, 45000));

        return view('back.eleve.questions.list',compact('questions','title','total','sortBy','sortDir'));
    }

    /**
     * qcmMassUpdate - Mise à jour globale de questions
     * @param  Request $request 
     * @return redirect
     */
    public function qcmMassUpdate(Request $request)
    {
        $datas      = $request->all();   
        $messages   = [];

        if(empty($datas['massupdate']) || empty($datas['ids']) ) 
            return redirect('/admin/question')->with('message', sprintf('Erreur dans la récupération des données'));

        //CAS PUBLIE / DEPUBLIER
        if($datas['massupdate'] == 'published' || $datas['massupdate'] == 'unpublished'){

            $questions = Question::whereIn('id', $datas['ids'])->get();

            foreach ($questions as $question ) {
                if($datas['massupdate'] == 'published')
                    $messages[] = Question::publish($question);
                else if($datas['massupdate'] == 'unpublished')
                   $messages[]  = Question::unpublish($question);
            }

            return redirect('/admin/question')->with('message', $messages);
        }
        //CAS SUPPRESSION
        else if($datas['massupdate'] == 'delete'){

            $delete = $this->destroyMany($datas['ids']); 

            if($delete)
                return redirect('/admin/question')->with('message', sprintf("Les questions ont bien été supprimées."));
            else
                return redirect('/admin/question')->with('message', sprintf("Erreur lors de la suppression des éléments."));
        }
    }

    /**
     * doQuestion - Formulaire pour faire la question par l'élève
     * @param  int  $question_id 
     * @return view
     */
    public function doQuestion($question_id)
    {
        $user = auth()->user();

        //Récupération du score de la question voulant être faite
        $score = Score::select('status_question')
                        ->where('user_id', '=', $user->id)
                        ->where('question_id','=',$question_id)
                        ->get()->first();

        //Si la question a déjà été faite, on empêche d'y accéder
        if($score->status_question == 'done')
            return redirect('/eleve/question')->with('message', sprintf("Vous ne pouvez pas accéder à une question déjà faite."));

        //Récupération de la question (+ image s'il y en a une) et des choix possibles
        $question = Question::with('choices','picture')
                            ->where('id', '=', $question_id)
                            ->get()->first();

        //Détermination des titres
        $title = $question->title;

        if($question->type == 'Simple')
            $subTitle = "Question à choix unique";
        else
            $subTitle = "Question à choix multiple";

        return view('back.eleve.questions.do',compact('question','title','subTitle')); 
    }

    /**
     * Supprimer plusieurs questions
     *
     * @param  array $id
     * @return boolean
     */
    public function destroyMany($ids)
    {
        if(!is_array($ids)) return;

        //Si image associée, la supprimer dans le dossier uploads
        $pictures = Picture::whereIn('question_id', $ids)->get();

        foreach ($pictures as $picture) 
            $this->destroyImage($picture->id);
        
        Question::whereIn('id', $ids)->delete();
        
        return true;
    }

    /**
     * Supprimer une question dont l'ID est passée en paramètre
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question   = Question::findOrFail($id);
        $picture    = Picture::where('question_id', $id)->get()->first(); 

        if($picture)
            $this->destroyImage($picture->id);

        $question->delete();
        
        return redirect('/admin/question')->with('message', sprintf("La question %s a été supprimée avec succès.",$question->title));
    }

    /**
     * Formulaire de création de question /
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title      = "Nouvelle question - 1/2";

        return view('back.admin.questions.createOrUpdate',compact('title'));
    }

     /**
     * upload Upload an image
     * 
     * @param file $im     
     * @param  string $name   
     * @param  int $postId 
     * @return picture object        
     */
    private function upload($im,$name,$questionId)
    {    
        $ext = $im->getClientOriginalExtension();   
        $uri = str_random(50).'.'.$ext;     
        $picture = Picture::create([
            'name'    => $name,
            'uri'     => $uri, 
            'size'    => $im->getSize(),
            'mime'    => $im->getClientMimeType(),
            'question_id' => $questionId
        ]);

        $im->move(env('UPLOAD_PICTURES','uploads'),$uri);

        return $picture;
    }

    /**
     * destroyImage - Supprimer une image du serveur
     * @param  int $pictureId 
     * @return  boolean
     */
    public function destroyImage($pictureId)
    {
       if(is_null($pictureId) || !is_numeric($pictureId)) return;

        $pic = Picture::findOrFail($pictureId);

        if($pic){
            $fileName = public_path('uploads') . DIRECTORY_SEPARATOR . $pic->uri;

            if(File::exists($fileName)){
                File::delete($fileName);

                return true;
            }
        }

        return false;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        //Création de la question
        $question   = Question::create($request->all());

        // Création des choix associés à la question
        $choix = ['question_id' => $question->id]; 
        for($i = 0; $i < $request->nbchoix; $i++)
        	 Choice::create($choix);

        //Création des scores des élèves de la même classe que celle de la question
        $users = User::select('id')
                ->where('role_id' , '=' , 2)
                ->where('class_level_id', '=' , $question->class_level_id)
                ->get();

        $data = [];

        foreach ($users as $user) 
            $data[] = ['user_id'=> $user->id, 'question_id'=> $question->id];

        Score::insert($data);

        //Uoload de l'image s'il y en a une
        if(!is_null($request->file('picture')))
           $picture = $this->upload($request->file('picture'), $request->input('picture_name'),$question->id);
    
        return redirect('/admin/choice/'.$question->id)->with('message', sprintf("La question \"%s\" a été créé avec succès.",$request->title));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $question = Question::findOrFail($id);

        if(!empty($question->picture_id))
            $picture    = Picture::findOrFail($question->picture_id);
        else $picture = null;

        $title      = 'Editer une question';

        return view('back.admin.questions.createOrUpdate',compact('question','title','picture'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, $id)
    {
        $data = $request->all();
        $question = Question::findOrFail($id);
        
        //Changement de Niveau de Classe de la question
        if($data['class_level_id'] != $question->class_level_id)
        {
            //Si la question est publiée, on supprime les scores dont la question correspondante n'est pas faite seulement
            if($question->status == 'Publié'){
                $scoreToDelete = Score::where('question_id',$question->id)
                                       ->where('status_question','notdone')
                                       ->delete();
            //Si la question n'est pas publié, dans ce cas on supprime tous les scores
            }else{
                $scoreToDelete = Score::where('question_id',$question->id)->delete();
            }
        }
      
        //Update de la question
        $question->update($request->all());

        //Récupération des questions déjà faites
        $scoresDone = Score::select('user_id')
                             ->where('question_id',$question->id)
                             ->where('status_question','done')
                             ->get();

        //Détermination des IDS à excluse pour la création des nouveaux scores
        $excluIds = [];
        foreach ($scoresDone as $score)
            $excluIds[] = $score->user_id;
        
        //Création des scores pour la nouvelle classe
        $users = User::select('id')
                ->where('role_id' , '=' , 2)
                ->where('class_level_id', '=' , $data['class_level_id'])
                ->whereNotIn('id',$excluIds)
                ->get();

        $data = [];
        foreach ($users as $user) 
            $data[] = ['user_id'=> $user->id, 'question_id'=> $question->id];

        Score::insert($data);

        //CAS Suppression de l'image
       if($request->input('deleteImage') == "on"){
            $this->destroyImage($question->picture->id);
            $question->picture->delete();
        }
        //CAS remplacement/update de l'image
        else if($request->file('picture')){
            if($question->picture) {
                $this->destroyImage($question->picture->id);
                $question->picture->delete();
            }
            $picture = $this->upload($request->file('picture'), $request->input('picture_name'),$question->id);
        }
        //Cas changement du nom de l'image
        else if(!$request->file('picture') && $question->picture && !empty($request->input('picture_name'))){
            $question->picture->update(['name' => $request->input('picture_name')]);
        }

        return redirect('/admin/choice/'.$question->id)->with('message', sprintf("La question \"%s\" a été modifiée avec succès.",$question->title));
    }
}
