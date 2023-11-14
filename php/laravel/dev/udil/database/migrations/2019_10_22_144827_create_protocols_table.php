<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocols', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');

            $table->string('communication_profile_type_idt');
            $table->string('idt');
            $table->string('name');
            $table->string('description')->nullable();

            CommonMigrations::five($table);
        });

        DB::table('protocols')
            ->insert([
                [ 'id' => Uuid::generate(), 'communication_profile_type_idt' => 'database', 'idt' => 'mysql', 'name' => 'MySQL', 'description' => 'MySQL Database' ],
                [ 'id' => Uuid::generate(), 'communication_profile_type_idt' => 'database', 'idt' => 'sqlsrv', 'name' => 'MSSQL', 'description' => 'MSSQL Database' ],
                [ 'id' => Uuid::generate(), 'communication_profile_type_idt' => 'database', 'idt' => 'oracle', 'name' => 'ORACLE', 'description' => 'ORACLE Database' ],
                [ 'id' => Uuid::generate(), 'communication_profile_type_idt' => 'database', 'idt' => 'mongo', 'name' => 'Mongo DB', 'description' => 'No SQL DB' ],
                [ 'id' => Uuid::generate(), 'communication_profile_type_idt' => 'database', 'idt' => 'nosql', 'name' => 'NoSQL', 'description' => 'No SQL Databases' ],
                [ 'id' => Uuid::generate(), 'communication_profile_type_idt' => 'rest', 'idt' => 'rest', 'name' => 'REST-Ful', 'description' => 'Restful Web Services' ],
                [ 'id' => Uuid::generate(), 'communication_profile_type_idt' => 'cim-soap', 'idt' => 'soap', 'name' => 'SOAP ', 'description' => 'Soap Web Services' ],
                [ 'id' => Uuid::generate(), 'communication_profile_type_idt' => 'cim-soap', 'idt' => 'cim', 'name' => 'CIM-Http', 'description' => null ],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('protocols');
    }
}
