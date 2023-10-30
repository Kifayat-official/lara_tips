<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInMdcTestSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdc_test_sessions', function (Blueprint $table) {
            $table->string('mdc_name')->nullable()->after('mdc_version');
            $table->string('mdc_size')->nullable()->after('mdc_name');
            $table->string('mdc_os_name_version')->nullable()->after('mdc_size');
            $table->string('meter_firmware_version')->nullable()->after('mdc_os_name_version');
            $table->string('meter_firmware_size')->nullable()->after('meter_firmware_version');
            $table->string('udil_version')->nullable()->after('meter_firmware_size');
            $table->string('tender_number')->nullable()->after('udil_version');
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
            $table->dropColumn([
                'mdc_name',
                'mdc_size',
                'mdc_os_name_version',
                'meter_firmware_version',
                'meter_firmware_size',
                'udil_version',
                'tender_number',
            ]);
        });
    }
}
