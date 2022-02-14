<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('title_kh')->nullable();
            $table->text('description')->nullable();
            $table->text('description_kh')->nullable();
            $table->text('image')->nullable();
            $table->text('gallery')->nullable();
            $table->text('place')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->bigInteger('hosted_by')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->bigInteger('auth_by')->unsigned()->nullable();
            $table->timestamp('auth_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hosted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshops');
    }
}
