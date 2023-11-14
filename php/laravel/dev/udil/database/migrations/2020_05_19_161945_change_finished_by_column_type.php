<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFinishedByColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdc_test_sessions', function (Blueprint $table) {
            $table->dropColumn(['finished_by']);
        });

        Schema::table('mdc_test_sessions', function (Blueprint $table) {
            $table->uuid('finished_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mdc_test_sessions', function (Blueprint $table) {
            //
        });
    }
}
