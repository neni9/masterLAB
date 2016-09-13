<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
                [
                    'title' => 'teacher',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' => 'student',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ]
            ]
        );
    }
}
