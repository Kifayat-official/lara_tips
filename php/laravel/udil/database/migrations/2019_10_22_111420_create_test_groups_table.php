<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_groups', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');
            
            $table->string('name');
            $table->string('description')->nullable();

            CommonMigrations::five($table);
        });

        DB::table('test_groups')
            ->insert([
                [ 'id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'name' => 'MDM Interoperability Tests' ],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_groups');
    }
}
