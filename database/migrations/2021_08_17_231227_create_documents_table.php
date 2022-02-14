<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_kh')->nullable();
            $table->text('description')->nullable();
            $table->text('description_kh')->nullable();
            $table->text('path')->nullable();
            $table->text('path_kh')->nullable();
            $table->string('type', 50)->nullable();
            $table->boolean('is_active')->nullable();
            $table->bigInteger('auth_by')->unsigned()->nullable();
            $table->timestamp('auth_at')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('status', 10)->nullable();

            $table->foreign('auth_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
