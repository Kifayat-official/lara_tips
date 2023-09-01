<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communication_profiles', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');
            
            $table->uuid('communication_profile_type_id');
            $table->uuid('protocol_id');
            $table->string('host');
            $table->string('username');
            $table->string('password')->nullable();
            $table->integer('port')->nullable();
            $table->string('database')->nullable();
            $table->string('code')->nullable();

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
        Schema::dropIfExists('communication_profiles');
    }
}
