<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('gender', 10)->nullable();
            $table->date('dob')->nullable();
            $table->string('school', 50)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('address')->nullable();
            $table->text('profile')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('status', 10)->nullable();
            $table->bigInteger('auth_by')->unsigned()->nullable();
            $table->timestamp('auth_at')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
