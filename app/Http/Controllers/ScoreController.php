<?php

namespace App\Http\Controllers;

use View;
use App\User;
use App\Score;
use App\Choice;
use App\Question;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use App\Http\Requests\QuestionRequest;

class ScoreController extends Controller
{

    /**
     * score inccorect
     * @var integer
     */
	private $wrong 		= 0;

    /**
     * score Partiellement correct
     * @var float
     */
	private $halftrue 	= 0.5;

    /**
     * score correct
     * @var integer
     */
	private $correct 	= 1;

    /**
     * __construct 
     * 
     */
    public function __construct(){}

    /**
     * resultat Détermine le résultat de l'élève à une question et renvoie toutes les données nécessaires pour 
     * la réponse de la question
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function resultat(Request $request)
    {
        $resultat                   = [];

        if($request->isMethod('post')){

            //Récupération des réponses correctes à la question
    		$reponses = Choice::select('id')
    						   ->where('question_id', '=' ,$request->question_id)
    						   ->where('status', '=', 'yes')
    						   ->get();

            //CAS QUESTION A CHOIX SIMPLE
    		if($request->question_type == 'Simple'){

                //Détermination de la note
    			$note = ($request->choice == $reponses[0]->id) ? $this->correct : $this->wrong;

                switch ($note) {
                    case 1:
                        $message = "correct";
                        break;
                    case 0.5:
                        $message = "half-correct";
                        break;
                    default:
                        $message = "wrong";
                        break;
                }

                //Récupération de l'explication de la question
                $question = Question::select('explication')->where('id','=',$request->question_id)->get()->first();

                //Construction du retour
                $resultat['explication']    = $question->explication;
                $resultat['choices']        = [$request->choice];
                $resultat['correction']     = [$reponses[0]->id];
                $resultat['note']           = $note;
                $resultat['status']         = "success";
                $resultat['message']        = $message;

            //CAS CHOIX A REPONSES MULTIPLES
    		}else{

                //Détermination des bonnes réponses 
    			$correctChoices = [];

                if(!is_null($request->choices)){
        			foreach ($reponses as $reponse) 
        					$correctChoices[] = $reponse->id;
                }
    			
                //Détermination du nombre de réponses juste de l'élève
    			$result = 0;
                if(!is_null($request->choices)){
        			foreach ($request->choices as $choiceId) {
        				if(in_array($choiceId,$correctChoices))
        					$result++;
        			}
                }

                //CAS L'élève a tout bon : correct
    			if(count($correctChoices) == $result && $result == count($request->choices)) 					  
                    $note = $this->correct;
                //CAS 2 : L'élève a partiellement correct
    			else if($result > 0 && $request->choices  != count($correctChoices) ) 
                    $note = $this->halftrue;
                //Sinon : l'élève à faux
    			else 													  
                    $note = $this->wrong;
                
                //Détermination du message afficher le bon panel dans la view
                if($note == 1) 
                    $message = "correct";
                else if($note == 0.5) 
                    $message = "half-correct";
                else
                    $message = "wrong";

                //Récupération de la question
                $question = Question::select('explication')->where('id','=',$request->question_id)->get()->first();

                //Construction de la réponse
                $resultat['explication']    = $question->explication;
                $resultat['choices']        = $request->choices;
                $resultat['correction']     = $correctChoices;
                $resultat['note']           = $note;
                $resultat['status']         = "success";
                $resultat['message']        = $message;
    		}

            //ON change le status du score à FAIT et on sauvegarde la note de l'élève
            $data = [
                'status_question' => 'done',
                'note'            => $note
            ];

            $score = Score::where('user_id', '=', $request->user_id)
                            ->where('question_id', '=', $request->question_id)
                            ->get()
                            ->first();

    		Score::where('id', '=', $score->id)
    			 ->update($data);

            return $resultat;
    	}

    }
}