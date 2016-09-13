<?php

namespace App\Http\Controllers;

use View;
use App\Choice;
use App\Question;
use App\Http\Requests;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    
     /**
     * Affiche la view du formulaire de création/édition des choix d'une question
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function createChoices($question_id)
    {
        $title      = 'Nouvelle Question - 2/2';

        $question   = Question::findOrFail($question_id);
        $choix      = Choice::where('question_id', $question->id)->get();

        return view('back.admin.choices.createOrUpdate',compact('question','choix','title'));
    }

    /**
     * Store the question's choices
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeChoices(Request $request)
    {
    	foreach ($request->choice_ids as $key => $choiceId) {

    		if($request->question_type == 'Multiple')
    			$status = $request['status_'.$choiceId];
    		else
    			$status = ($request->status == $choiceId) ? 'yes' : 'no';

            $update = [
                'content' => $request['content_'.$choiceId],
                'status'  => $status
            ];
    		
    		Choice::where('id','=',$choiceId)->update($update);
    	}

        if($request->published == "on")
            Question::where('id',$request->question_id)->update(['status' => 'published']);
        

    	return redirect('/admin/question')->with('message', sprintf("La question et ses choix ont été sauvegardés avec succès."));
    
    }

}
