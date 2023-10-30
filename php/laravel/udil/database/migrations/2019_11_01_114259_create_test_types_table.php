<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_types', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');
            $table->string('idt')->unique();
            $table->string('name');
            CommonMigrations::five($table);
        });

        DB::table('test_types')
            ->insert([
                [
                    'id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667',
                    'idt' => 'read',
                    'name' => 'Reading Test'
                ],
                [
                    'id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667',
                    'idt' => 'write',
                    'name' => 'Writing Test'
                ],
                [
                    'id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667',
                    'idt' => 'on_demand',
                    'name' => 'On Demand Test'
                ],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_types');
    }
}
