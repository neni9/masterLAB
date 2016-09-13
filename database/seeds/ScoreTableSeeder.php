<?php

use App\User;
use App\Question;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$users = User::where('role_id','=',2)
    			->where('status','=','actif')
    			->get();

    	$datas = [];

        $questions = Question::all();

        $notes  = [0,0.5,1];
        $status = ['done','notdone'];

    	foreach ($users as $user) {
    		foreach ($questions as $question) {
                if($question->class_level_id == $user->class_level_id){
        			$datas[] = [
        				'user_id'           => $user->id,
        				'question_id'       => $question->id,
                        'note'              => $notes[array_rand($notes)],
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                        'status_question'   =>'notdone'
        			];	

                    $key = array_keys($datas);
                    $lastKey = end($key);
                    if($datas[$lastKey]['note'] == 0.5 || $datas[$lastKey]['note'] == 1)
                        $datas[$lastKey]['status_question'] = 'done';
                    else
                       $datas[$lastKey]['status_question'] = $status[array_rand($status)];
                }
    		}
    	}
    	
        DB::table('scores')->insert($datas);
    }
}
