<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsDateToContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->datetime('start_at')->nullable();
            $table->datetime('end_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contests', function (Blueprint $table) {
            $table->dropColumn(['start_at', 'end_at']);
        });
    }
}
