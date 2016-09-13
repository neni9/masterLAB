<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username',50);
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('password');
            $table->enum('status', ['actif', 'inactif'])->default('actif');
            $table->rememberToken();
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('class_level_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('users');
    }
}
