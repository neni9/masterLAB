<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
            	[           									  //TEACHER
                	'username'       => 'alvarden',
                    'first_name'     => 'Alexandre',
                    'last_name'      => 'Varden',
                    'email'	         => 'alexandrevarden@teacher.fr',
                    'password'       => bcrypt('alexandre'),
                    'role_id'        => 1,
                    'class_level_id' => NULL,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [                                                 
                    'username'      => 'dabeaudin',
                    'email'         => 'danielbeaudouin@teacher.fr',
                    'first_name'    => 'Daniel',
                    'last_name'     => 'Beaudouin',
                    'password'      => bcrypt('daniel'),
                    'role_id'       => 1,
                    'class_level_id' => NULL,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],	
                [                                                 
                    'username'      => 'odparenteau',
                    'email'         => 'odetteparenteau@teacher.fr',
                    'first_name'    => 'Odette',
                    'last_name'     => 'Parenteau',
                    'password'      => bcrypt('odette'),
                    'role_id'       => 1,
                    'class_level_id' => NULL,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],  											   //FIRST_CLASS
                [
                    'username' => 'abricher',
                    'email'	   => 'abelricher@student.fr',
                    'first_name'    => 'Abel',
                    'last_name'     => 'Richer',
                    'password' => bcrypt('abel'),
                    'role_id'  => 2, 
                    'class_level_id' => 1,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'username'      => 'algaillard',
                    'email'	        => 'algaillard@student.fr',
                    'first_name'    => 'Al',
                    'last_name'     => 'Gaillard',
                    'password'      => bcrypt('al'),
                    'role_id'       => 2, 
                    'class_level_id' => 1,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'alchauvet',
                    'email'	        => 'alanchauvet@student.fr',
                    'first_name'    => 'Alan',
                    'last_name'     => 'Chauvet',
                    'password'      => bcrypt('alan'),
                    'role_id'       => 2, 
                    'class_level_id' => 1,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'Arthur',
                    'email'	        => 'arthur@student.fr',
                    'first_name'    => 'Arthur',
                    'last_name'     => 'Gaillard',
                    'password'      => bcrypt('arthur'),
                    'role_id'       => 2, 
                    'class_level_id' => 1,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'caguernon',
                    'email'	        => 'carlguernon@student.fr',
                    'first_name'    => 'Carl',
                    'last_name'     => 'Guernon',
                    'password'      => bcrypt('carl'),
                    'role_id'       => 2, 
                    'class_level_id' => 1,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'bllauzier',
                    'email'	        => 'blaiselauzier@student.fr',
                    'first_name'    => 'Blaise',
                    'last_name'     => 'Lausier',
                    'password'      => bcrypt('blaise'),
                    'role_id'       => 2, 
                    'class_level_id' => 1,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'isdaoust',
                    'email'	        => 'isaacdaoust@student.fr',
                    'first_name'    => 'Isaac',
                    'last_name'     => 'Daoust',
                    'password'      => bcrypt('isaac'),
                    'role_id'       => 2, 
                    'class_level_id' => 1,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'stgabriaux',
                    'email'	        => 'stevegabriaux@student.fr',
                    'first_name'    => 'Steve',
                    'last_name'     => 'Gabriaux',
                    'password'      => bcrypt('steve'),
                    'role_id'       => 2, 
                    'class_level_id' => 1,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],													//LAST_CLASS
                [          
                	'username'      => 'alleclair',
                    'email'	        => 'alfredleclair@student.fr',
                    'first_name'    => 'Alfred',
                    'last_name'     => 'Leclair',
                    'password'      => bcrypt('alfred'),
                    'role_id'       => 2, 
                    'class_level_id' => 1,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'username'      => 'brtalon',
                    'email'	        => 'brendantalon@student.fr',
                    'first_name'    => 'Brendon',
                    'last_name'     => 'Talon',
                    'password'      => bcrypt('brendan'),
                    'role_id'       => 2, 
                    'class_level_id' => 2,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'username'      => 'dabeauchesne',
                    'email'	        => 'davidbeauchesne@student.fr',
                    'first_name'    => 'David',
                    'last_name'     => 'Beauchesne',
                    'password'      => bcrypt('david'),
                    'role_id'       => 2, 
                    'class_level_id' => 2,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'         => 'gedenis',
                    'email'	        => 'georgedenis@student.fr',
                    'first_name'    => 'George',
                    'last_name'     => 'Denis',
                    'password'      => bcrypt('george'),
                    'role_id'       => 2, 
                    'class_level_id' => 2,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'jiayot',
                    'email'	        => 'jimayot@student.fr',
                    'first_name'    => 'Jim',
                    'last_name'     => 'Ayot',
                    'password'      => bcrypt('jim'),
                    'role_id'       => 2, 
                    'class_level_id' => 2,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'lesevier',
                    'email'	        => 'lesliesevier@student.fr',
                    'first_name'    => 'Leslie',
                    'last_name'     => 'Sevier',
                    'password'      => bcrypt('leslie'),
                    'role_id'       => 2, 
                    'class_level_id' => 2,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'marobert',
                    'email'	        => 'mariarobert@student.fr',
                    'first_name'    => 'Maria',
                    'last_name'     => 'Robert',
                    'password'      => bcrypt('maria'),
                    'role_id'       => 2, 
                    'class_level_id' => 2,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'racormier',
                    'email'	        => 'rasmuscormier@student.fr',
                    'first_name'    => 'Rasmus',
                    'last_name'     => 'Cormier',
                    'password'      => bcrypt('rasmus'),
                    'role_id'       => 2, 
                    'class_level_id' => 2,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                	'username'      => 'ticorbin',
                    'email'	        => 'timcorbin@student.fr',
                    'first_name'    => 'Tim',
                    'last_name'     => 'Corbin',
                    'password'      => bcrypt('tim'),
                    'role_id'       => 2, 
                    'class_level_id' => 2,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
            ]
        );
    }
}
