<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldForTrackingExamToRegisteredContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registered_contests', function (Blueprint $table) {
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registered_contests', function (Blueprint $table) {
            $table->dropColumn('start_at');
            $table->dropColumn('end_at');
        });
    }
}
