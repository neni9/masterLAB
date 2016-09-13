<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClasslevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('class_levels')->insert(
            [
                [
                    'title' => 'first_class',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ],
                [
                    'title' => 'final_class',
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ]
            ]
        );
    }
}
