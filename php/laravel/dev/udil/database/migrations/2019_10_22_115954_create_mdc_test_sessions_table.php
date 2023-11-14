<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMdcTestSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdc_test_sessions', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');
            
            $table->bigInteger('id_numeric')->unique();
            $table->datetime('start_datetime')->nullable();
            $table->datetime('end_datetime')->nullable();
            $table->uuid('company_id')->nullable();
            $table->string('company_rep')->nullable();
            $table->string('company_rep_designation')->nullable();
            $table->string('mdc_version')->nullable();
            $table->boolean('is_gprs')->nullable()->default(false);
            $table->boolean('is_rf')->nullable()->default(false);
            $table->boolean('is_plc')->nullable()->default(false);
            $table->boolean('is_wifi')->nullable()->default(false);
            $table->boolean('is_zigbee')->nullable()->default(false);
            $table->boolean('is_lan')->nullable()->default(false);
            $table->uuid('read_profile_id')->nullable();
            $table->uuid('write_profile_id')->nullable();
            $table->text('remarks')->nullable();  
            $table->uuid('test_profile_id');
            $table->boolean('is_transaction_status_api_based')->nullable()->default(false);
            $table->text('privatekey')->nullable();
            $table->boolean('is_pass')->default(false);
            $table->boolean('is_finished')->default(false);
            
            CommonMigrations::five($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mdc_test_sessions');
    }
}
