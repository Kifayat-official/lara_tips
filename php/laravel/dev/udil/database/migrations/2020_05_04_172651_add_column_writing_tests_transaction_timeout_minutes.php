<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnWritingTestsTransactionTimeoutMinutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdc_test_sessions', function (Blueprint $table) {
            $table->integer('writing_tests_transaction_timeout_minutes')->default(3)->after('is_transaction_status_api_based');
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
            $table->dropColumn(['writing_tests_transaction_timeout_minutes']);
        });
    }
}
