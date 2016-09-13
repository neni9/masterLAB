<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert(
            [
                [
                    'title' 	  	 => "Probabilités",
                    'content' 		 => "On lance un dé équilibré à six faces et on note le résultat de la face du dessus. La probabilité d'obtenir un nombre divisble par 3 est de :",
                    'status' 		 => "published",
                    'class_level_id' => 1,
                    'explication'    => "",
                    'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Piscine", 
                    'content' 		 => "Une piscine parallélépipédique a pour dimensions : 2 m de profondeur et 25 m de longueur. Sachant que le m3 d’eau revient à 0,84 € et que le propriétaire paie 420 € quand il la remplit, quelle est la largeur de la piscine ?", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Course de chevaux", 
                    'content' 		 => "Six chevaux sont au départ d'une course. Combien de combinaisons sont possibles pour l'ordre d'arrivée ?", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'	 => "On compte 6 possibilités pour la place 1, puis 5 possibilités pour la place 2, et donc 6×5 possibilités pour les deux premières places etc. On a donc 6×5×4×3×2 = 720 combinaisons possibles.",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Equation de premier degré", 
                    'content' 		 => "Donnez l'unique solution de l'équation 5 (2x + 1) - (3x +5) = 2x", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'	 => "En développant et en simplifiant l'équation, on obtient 7x = 2x, soit 5x = 0", 
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Factorisation", 
                    'content' 		 => "Cochez le(s) forme(s) factorisée(s) de 3x + 3 - (x + 1)² :", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'	 => "",
                     'type'          => 'multiple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Fonctions et lectures graphiques", 
                    'content' 		 => "La représentation graphique de la fonction carré est une : ", 
                    'status' 		 => "unpublished", 
                    'class_level_id' => 1,
                    'explication' 	 => '',
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Fonctions et lectures graphiques", 
                    'content' 		 => "La fonction carré, qui à x associe x² sur l'ensemble des réels noté R négatifs, est strictement :", 
                    'status' 		 => "unpublished", 
                    'class_level_id' => 1,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Développement d'une expression", 
                    'content' 		 => "Développer l'expression : (a + 2b) (a -2b) :", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'    => "",
                    'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Factorisation d'une expression", 
                    'content' 		 => "Factoriser l'expression : 2a² - a :", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Equation de degré 2", 
                    'content' 		 => "Le polynôme x² - 5x a pour discriminant(s)  :", 
                    'status' 		 => "unpublished", 
                    'class_level_id' => 1,
                    'explication'    => "Le discriminant vaut (- 5)² - 4*1*0 = 25 - 0 = 25",
                     'type'          => 'multiple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Equation de degré 2", 
                    'content' 		 => "L'équation 2x² - 5x - 7 = 0 a pour solution(s) : ", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'    => "Les solutions sont (5 - 9)/4 = - 1 et (5 + 9)/4 = 7/2",
                     'type'          => 'multiple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Equation de degré 2", 
                    'content' 		 => "Combien de solution(s) admet l'équation x² + 1 = 0 : ", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'    => "Il n'y a aucune solution pour cette équation : x² + 1 = 0 équivaut à x² = - 1 ce qui est impossible dans IR, (le carré d'un réel est positif ou nul)",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Nombre premier", 
                    'content' 		 => "Une methode qui consiste à trouver les nombres premiers est appelée la crible :", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'    => "L'algorithme procède par élimination : il s'agit de supprimer d'une table des entiers de 2 à N tous les multiples d'un entier. En supprimant tous les multiples, à la fin il ne restera que les entiers qui ne sont multiples d'aucun entier, et qui sont donc les nombres premiers.

						On commence par rayer les multiples de 2, puis à chaque fois on raye les multiples du plus petit entier restant.

						On peut s'arrêter lorsque le carré du plus petit entier restant est supérieur au plus grand entier restant, car dans ce cas, tous les non-premiers ont déjà été rayés précédemment.

						À la fin du processus, tous les entiers qui n'ont pas été rayés sont les nombres premiers inférieurs à N.",
                    'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Nombre premier", 
                    'content' 		 => "Combien y'a-t-il de nombres premiers inférieur à 100 ? ", 
                    'status' 		 => "unpublished", 
                    'class_level_id' => 1,
                    'explication'    => "Les vingt-cinq nombres premiers inférieurs à 100 sont : 2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89 et 97.",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Fonction linéaire", 
                    'content' 		 => "Toute fonction linéaire est : ", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Moyenne harmonique", 
                    'content' 		 => "On donne x = 3 et y = 5. Quelle est la moyenne harmonique de x et y? ", 
                    'status' 		 => "published", 
                    'class_level_id' => 1,
                    'explication'    => "", 
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Fonction carré", 
                    'content' 		 => "Dans un repère orthogonal, la courbe représentative de la fonction carrée est :", 
                    'status' 		 => "published", 
                    'class_level_id' => 2,
                    'explication'    => "", 
                     'type'          => 'multiple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Problème de famille", 
                    'content' 		 => "Un homme de 40 ans a un fils de 9 ans. Dans combien de temps l'âge du père sera t-il le double de l'âge du fils?", 
                    'status' 		 => "published", 
                    'class_level_id' => 2,
                    'explication'    => "Quand le fils est né, le père avait 31 ans donc le père aura le double de l'age de son fils quand le fils aura 31 ans. Le père aura 62 ans, donc 40 + 22 ans. ",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Laboratoire", 
                    'content' 		 => "Une bactérie se multiplie à chaque seconde (elle se scinde en deux, en quatre etc.).
					Au bout d'une minute, on a réussi à remplir un bocal plein de bactéries.
					Combien de temps faudra-t-il pour remplir ce même bocal si nous avons 4 fois plus de bactéries qu'au départ ?", 
                    'status' 		 => "published", 
                    'class_level_id' => 2,
                    'explication'    => "58 secondes. Une bactérie se multipliant par 2 en 1 seconde, elle se multiplie par 4 en 2 secondes.
                        D'où, avec 4 fois plus de bactéries, une économie de temps de 2 secondes, il faut donc: 60-2 = 58 secondes pour remplir le bocal.",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Les femmes en entreprise", 
                    'content' 		 => "Une entreprise est implantée sur deux sites A et B. Un audit indique que les hommes représentent respectivement 40 % et 60 % des employés des sites A et B, et qu’il y a trois fois plus d’employés sur le site B que sur le site A. Quel est le pourcentage de femmes au sein de cette entreprise de 9 700 salariés ? ", 
                    'status' 		 => "published", 
                    'class_level_id' => 2,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Somme", 
                    'content' 		 => "Quelle est la somme de : 3 jours 21 heures 55 minutes 29 secondes et 2 jours 22 heures 42 minutes 36 secondes ? ", 
                    'status' 		 => "published", 
                    'class_level_id' => 2,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Plus Petit Diviseur Commun", 
                    'content' 		 => "Quel est le plus grand diviseur commun de : 3 179 ; 2 431 ; 4 641 ? ", 
                    'status' 		 => "published", 
                    'class_level_id' => 2,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Combien de barres?", 
                    'content' 		 => "Un camion vide pèse 1,8 tonne.
					Combien pourra-t-il transporter de barres de fer (1dm3 de fer pèse 7,8 kg) de 20 m de long et de section carrée de 10 cm de carré,

					sachant que ce véhicule doit emprunter un pont ne pouvant supporter plus de 20 tonnes ? ", 
                    'status' 		 => "unpublished", 
                    'class_level_id' => 2,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Equation", 
                    'content' 		 => "Résoudre l'inéquation : 8x + 1 < 6x - 15 : ", 
                    'status' 		 => "unpublished", 
                    'class_level_id' => 2,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Vitesse de la lumière", 
                    'content' 		 => "La vitesse de la lumière est estimée a 299 792,5 km/s (kilometre par seconde). Comment peut-on également exprimer cette vitesse ?", 
                    'status' 		 => "published", 
                    'class_level_id' => 2,
                    'explication'    => "",
                     'type'          => 'multiple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Moyenne de l'élève", 
                    'content' 		 => "L'élève ne se souvient plus du coefficient pour les mathématiques. Quel est le coefficient de cette épreuve, sachant que sa moyenne s'élève à 13,1 et que l'élève a eu : 14 en Physique (coeff 3), 12 en Français (coeff 3), 12,5 en Anglais (coeff 2), et 13.5 en Mathématiques (coeff inconnu) ?", 
                    'status' 		 => "published", 
                    'class_level_id' => 2,
                    'explication'    => "",
                     'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' 	  	 => "Factorisation d'une équation", 
                    'content' 		 => "Quel est le résultat factorise de l'expression suivante ? 3X² – 3 + (X – 1) (2X + 5) ?", 
                    'status' 		 => "published", 
                    'class_level_id' => 2,
                    'explication'    => "",
                    'type'          => 'simple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title'          => "Lemniscate", 
                    'content'        => "Cochez les affirmations correctes à propos du mot Lemniscate :", 
                    'status'         => "published", 
                    'class_level_id' => 2,
                    'explication'    => "Le mot Lemniscate représente un symbole qui est celui qui de l’infini. Ce signe est connu depuis l’antiquité grecque mais c’est le mathématicien Bernoulli qui lui trouva son nom en 1694 s’inspirant du terme latin lemniscus qui signifie ruban.",
                    'type'          => 'multiple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title'          => "L'origine des échecs", 
                    'content'        => "Cochez les affirmations correctes à propos de l'équation E=mc² :", 
                    'status'         => "published", 
                    'class_level_id' => 1,
                    'explication'    => "E=mc², équation posée par Einstein en 1905, représente la loi de conservation de l’énergie. Cette loi définit l’équivalence entre la masse et l’énergie : E : Energie exprimée en jouls, m : Masse d’un objet exprimée en kilogrammes, c : Célérite (vitesse de la lumière dans le vide) exprimée en m/s. Si l’on multiplie la masse d’un corps par la vitesse de la lumière on obtient une énergie. La représentation physique de cette formule permettrait d’extraire une énergie d’une masse, ce qui est à l’origine de la fission nucléraire donnant naissance à la bombe atomique et l’énergie nucléaire.",
                    'type'          => 'multiple',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
            ]
        );
    }
}
