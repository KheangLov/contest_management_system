<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_correct')->nullable();
            $table->bigInteger('registered_contest_id')->unsigned()->nullable();
            $table->bigInteger('question_id')->unsigned()->nullable();
            $table->bigInteger('chose_answer_id')->unsigned()->nullable();

            $table->foreign('registered_contest_id')->references('id')->on('registered_contests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
}
