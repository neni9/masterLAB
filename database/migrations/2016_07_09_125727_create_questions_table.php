<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title',100);
            $table->text('content');
            $table->enum('status', ['published', 'unpublished'])->default('unpublished');
            $table->datetime('published_at')->nullable();
            $table->enum('type', ['simple', 'multiple'])->default('multiple');
            $table->text('explication')->nullable();
            $table->unsignedInteger('class_level_id')->nullable();
            $table->foreign('class_level_id')->references('id')->on('class_levels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
