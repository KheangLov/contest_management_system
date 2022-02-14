<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_registered_contests', function (Blueprint $table) {
            $table->bigInteger('registered_contest_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();

            $table->foreign('registered_contest_id')->references('id')->on('registered_contests');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_contests');
    }
}
