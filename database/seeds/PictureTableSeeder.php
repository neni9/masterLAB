<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PictureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pictures = [];

        for($i=1; $i<=50;$i++)
        {
            $uri = $i.'.jpg';
            $pictures[] = [
                'name'  => 'image '.$i,
                'uri' => $uri,
                'mime'    => 'image/jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'post_id' => $i
            ];
        }

         DB::table('pictures')->insert($pictures);
    }
}
