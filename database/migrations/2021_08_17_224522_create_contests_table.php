<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('title_kh')->nullable();
            $table->text('description')->nullable();
            $table->text('description_kh')->nullable();
            $table->text('image')->nullable();
            $table->integer('duration')->nullable();
            $table->string('status', 10)->nullable();
            $table->bigInteger('level_id')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->bigInteger('auth_by')->unsigned()->nullable();
            $table->timestamp('auth_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('level_id')->references('id')->on('levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contests');
    }
}
