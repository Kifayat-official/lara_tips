<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeeVoucherCoulumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdc_test_sessions', function (Blueprint $table) {
            $table->string('fee_voucher')->after('mdc_version')->nullable();
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
            $table->dropColumn(['fee_voucher']);
        });
    }
}
