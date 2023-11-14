<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationProfileTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communication_profile_types', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');
            
            $table->string('idt');
            $table->string('name');
            $table->string('description');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_write')->default(false);

            CommonMigrations::five($table);
        });

        DB::table('communication_profile_types')
            ->insert([
                [ 'id' => Uuid::generate(), 'idt' => 'database', 'name' => 'Database', 'description' => 'DB Tables/Views', 'is_read' => 1, 'is_write' => 0 ],
                [ 'id' => Uuid::generate(), 'idt' => 'rest', 'name' => 'Rest', 'description' => 'Rest Services', 'is_read' => 1, 'is_write' => 1 ],
                [ 'id' => Uuid::generate(), 'idt' => 'cim-soap', 'name' => 'CIM - SOAP', 'description' => 'CIM - SOAP', 'is_read' => 1, 'is_write' => 1 ],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communication_profile_types');
    }
}
