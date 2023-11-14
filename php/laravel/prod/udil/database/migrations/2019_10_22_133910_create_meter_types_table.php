<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeterTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meter_types', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');

            $table->string('name');
            $table->integer('phase');

            CommonMigrations::five($table);
        });

        DB::table('meter_types')
            ->insert([
                [ 'id' => Uuid::generate(), 'name' => 'Single Phase', 'phase' => 1],
                [ 'id' => Uuid::generate(), 'name' => 'Three Phase Whole Current', 'phase' => 3],
                [ 'id' => Uuid::generate(), 'name' => 'Three Phase LT-TOU', 'phase' => 3],
                [ 'id' => Uuid::generate(), 'name' => 'Three Phase HT-TOU', 'phase' => 3],
                [ 'id' => Uuid::generate(), 'name' => 'Three Phase Wide Range LT/HT', 'phase' => 3],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meter_types');
    }
}
