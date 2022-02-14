<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopJoinersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_joiners', function (Blueprint $table) {
            $table->bigInteger('workshop_id')->unsigned()->nullable();
            $table->bigInteger('joiner_id')->unsigned()->nullable();

            $table->foreign('workshop_id')->references('id')->on('workshops');
            $table->foreign('joiner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshop_joiners');
    }
}
