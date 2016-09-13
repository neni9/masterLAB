<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(ClasslevelTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
        $this->call(ChoiceTableSeeder::class);
        $this->call(ScoreTableSeeder::class);
        $this->call(PictureTableSeeder::class);
    }
}
