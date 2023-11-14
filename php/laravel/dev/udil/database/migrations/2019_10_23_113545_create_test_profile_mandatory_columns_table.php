<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestProfileMandatoryColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_profile_mandatory_columns', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');

            $table->uuid('test_profile_test_id');
            $table->string('column_name');

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
        Schema::dropIfExists('test_profile_mandatory_columns');
    }
}
