<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\User;
use App\Score;
use App\Post;
use App\Comment;
use App\Question;
use Carbon\Carbon;
use App\Class_level;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use App\Traits\TraitHighcharts;

class DashboardController extends Controller
{

    use TraitHighcharts;

    public function __construct(){}

    /**
     * admin DASHBOARD
     * @return view
     */
    public function admin()
    {
        $title = 'Dashboard admin';

        ////////// R E C U P E R A T I O N  I N F O S  P O U R  G R A P H S////////////////////////////////
        
        /**A R T I C L E S**/
        $articles                   = new \stdClass;
        $articles->last             = Post::with('user','commentsCount','picture')->last(3);
        $articles->topPublished     = Post::with('commentsCount')->top(5);
        $articles->publishedByMonth = Post::byMonth(12,'published');
        $articles->total = [
            'posts'         => Post::total(),
            'commentaires'  => Comment::count(),
            'published'     => [
                'count'   => Post::totalStatus('published'), 
                'percent' => Post::totalStatusPercent('published')
            ],
            'unpublished'   => [
                'count'   => Post::totalStatus('unpublished'), 
                'percent' => Post::totalStatusPercent('unpublished')
            ]
        ];

        /**Q C M**/

        $percentUnpublished       = Question::totalStatusPercent('unpublished');
        $percentPublished         = Question::totalStatusPercent('published');

        $qcm               = new \stdClass;
        $qcm->last         = Question::with('class_level')->last(3);
        $qcm->total        = [
            'questions'    => Question::total(),
            'published'    => [
                'count'    => Question::totalStatus('published'), 
                'percent'  => is_object($percentPublished) ? 0 : $percentPublished
            ],
            'unpublished'  => [
                'count'    => Question::totalStatus('unpublished'), 
                'percent'  => is_object($percentUnpublished) ? 0 : $percentUnpublished
            ],
            'simple'       => [
                'count'    => Question::totalType('simple'), 
                'percent'  => Question::totalTypePercent('simple')
            ], 
            'multiple'    => [
                'count'   => Question::totalType('multiple'), 
                'percent' => Question::totalTypePercent('multiple')
            ],
            'done'        => Score::totalStatus('done')
        ];

         //TOP 5 des questions les mieux réussies
        $bestQuestions  = Question::topCorrectQuestions(6);       

        /**E L E V E**/
        $total['eleve'] = User::where('role_id','=',2)
                                ->count();

        $total['eleve_actif'] = User::where('status','=','actif')
                                     ->where('role_id','=',2)
                                     ->count();

        $total['eleve_inactif'] = User::where('status','=','inactif')
                                      ->where('role_id','=',2)
                                      ->count(); 

        //TOP 5 des élèves possédant la meilleure/la pire moyenne (%)
        $bestEleves     = Question::topScoreEleve(5,'desc');   
        $badEleves      = Question::topScoreEleve(5,'asc');        

         /** G R A P H I Q U E S */
        $scores             = Question::pourcentageReussite();
        $graphReussiteGlob  = $this->graphTauxReussite($scores);
        $graph_postsByMonth = $this->graphPostByMonth($articles->publishedByMonth); 

        return view('back.admin.dashboard',compact('title','graphEtatPosts','graphEtatQcm','graph_postsByMonth','graphReussiteGlob','articles','qcm','bestQuestions','bestEleves','total','badEleves'));
    }

     /**
     * eleve DASHBOARD
     * @return view
     */
    public function eleve()
    {
        $user = auth()->user();

        $title = 'Dashboard Eleve';
       
        ////////// R E C U P E R A T I O N  I N F O S  P O U R  G R A P H S////////////////////////////////
        
        $total                              = [];
        $total['questions_done']            = Score::where('user_id','=',$user->id)
                                                    ->where('status_question','=','done')
                                                    ->count();
                        
        $total['questions_notdone']         = Score::where('user_id','=',$user->id)
                                                ->where('status_question','=','notdone')
                                                ->whereHas('question', function($query) {
                                                    $query->where('status', '=', 'published');
                                                })
                                                ->count();

        $total['score_incorrect']           = Score::totalNoteByUser(0,$user->id);
        $total['score_halfcorrect']         = Score::totalNoteByUser(0.5,$user->id);
        $total['score_correct']             = Score::totalNoteByUser(1,$user->id);
        
        $total['score']                     = Score::where('user_id','=',$user->id)
                                                     ->where('status_question','=','done')
                                                     ->sum('note');
        $total['percentScore']              = ($total['score'] != 0 && $total['questions_done'] != 0) ? round($total['score'] * 100 / $total['questions_done'],2) : 0;
        $total['questions']                 = Question::count();
        $total['questions_published']       = Question::where('status','=','published')->count();
        $total['questions_unpublished']     = Question::where('status','=','unpublished')->count();
        $total['questions_done_percent']    = ($total['questions_published'] != 0 && $total['questions_done'] != 0) ? round((int)$total['questions_published'] * (int)$total['questions_done'] / 100,2) : 0;
        $total['questions_notdone_percent'] = ($total['questions_published'] != 0 && $total['questions_notdone'] != 0) ? round((int)$total['questions_published'] * (int)$total['questions_notdone'] / 100,2) : 0; 

        $total['questions_simple']          = Question::totalType('simple');
        $total['questions_multiple']        = Question::totalType('multiple');

        //5 Dernières questions TODO panel
        $todo = Question::LastTodo(5,$user->id);

        /***** Graphique DETAIL SCORES QUESTIONS *****/
        $seriesDetailScores = [
            [
                'name' => 'Correct',
                'data' => [$total['score_correct']],
                'color' => '#45cefd'
            ],
            [
                'name' => 'Partiellement correct',
                'data' => [$total['score_halfcorrect']],
                'color' => '#6290fc'
            ],
            [
                'name' => 'Incorrect',
                'data' => [$total['score_incorrect']],
                'color' => '#7f52fb'
            ],
        ];

        $graphDetailScores = $this->highcharts_column(
            'Détails des scores obtenus',
            ['Résultats des questions'],
            'Nb de questions',
            $seriesDetailScores
        );

        /***** Graphique ETAT DES QCM A FAIRE / FAIT *****/
        $seriesEtatQcm = [[
            'type' => 'pie',
            'name' => 'Etat des QCM',
            'innerSize' => '50%',
            'data' => [
                [
                      'name'  => 'Fait : '.$total['questions_done'],
                      'y'     => $total['questions_done_percent'],
                      'color' => '#1de2bd'
                ], [
                      'name'    => 'Reste à faire :'.$total['questions_notdone'],
                      'y'       => $total['questions_notdone_percent'],
                      'color'   => '#eee966'
                ]
            ],    
        ]];

        $graphEtatQcm = $this->highcharts_semi_donut('Avancée <br>QCM',$seriesEtatQcm);
      
        /***** Graphique CIRCLE - Pourcentage SCORE reussite *****/
        $dataLabelsScore = [
            'format' => '<div style="text-align:center"><span style="font-size:25px;color:black">'.$total['percentScore'].' %</span><br/></div>'
        ];

        $graphScore = $this->highcharts_fullcircle(
            'Score',
            [$total['percentScore']],
            $dataLabelsScore
        );

        return view('back.eleve.dashboard',compact('title','graphDetailScores','graphEtatQcm','testChart','graphScore','total','todo'));
    }


    /**
     * graphPostByMonth - DASHBOARD ADMIN - Graphiques en colonnes "Nb d'articles par mois sur les 12 derniers mois"
     * @param  array $datas 
     * @return graph for highcharts
     */
    private function graphPostByMonth($datas)
    {
        $series = [];
        $categories  = [];
        foreach ($datas as $month => $posts) {
            $series[] = [
                'name' => $month,
                'y'    => $posts->count(),
                'drilldown' => $month
            ];
            $categories[] = $month;
        }

        $graphDatas = [[
            'name' => 'Articles',
            'colorByPoint' => false,
            'data' => $series
        ]];

        return $this->highcharts_column("Nb d'articles / mois sur les 12 derniers mois", $categories, "Nb d'articles",$graphDatas);
    }

    /**
     * graphTauxReussite - DASHBOARD ADMIN - Graphiques Taux de réussite globale en colonne
     * @param  array $datas 
     * @return graph for highcharts
     */
    private function graphTauxReussite($datas)
    {
        $series      = [];
        $class_level = new Class_level;

        foreach ($datas as  $score) {

            $color = $score->class_level_id == 1 ? '#7F52FB' : '#F86839';

             $series[] = [
                 'name'     => $class_level->getTitleAttribute($score->level_title),
                 'data'     => [ round($score->sumnote * 100 / $score->nbQcm,2)],
                 'color'    =>  $color 
             ];

        }

        return $this->highcharts_column(' ',['Niveau des classes'],' Pourcentage de réussite',$series);
    }


}
