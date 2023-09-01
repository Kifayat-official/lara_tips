<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_logs', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');
            
            $table->uuid('mdc_test_status_id');
            $table->uuid('mdc_test_session_id');
            $table->uuid('test_id');
            $table->boolean('is_pass')->default(false);
            $table->longText('remarks')->nullable();
            $table->string('attachment')->nullable();
            $table->longText('request')->nullable();
            $table->enum('response_type', ['table', 'json', 'xml'])->nullable();
            $table->longText('response')->nullable();

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
        Schema::dropIfExists('test_logs');
    }
}
