<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');

            $table->string('name');
            $table->string('description')->nullable();

            CommonMigrations::five($table);
        });

        DB::table('companies')
            ->insert([
                [ 'id' => Uuid::generate(), 'name' => 'KBK Electronics (Pvt.) Ltd.'],
                [ 'id' => Uuid::generate(), 'name' => 'Creative Electronics (Pvt.) Ltd.'],
                [ 'id' => Uuid::generate(), 'name' => 'Accurate (Pvt.) Ltd.'],
                [ 'id' => Uuid::generate(), 'name' => 'Microtech Industries (Pvt.) Ltd.'],
                [ 'id' => Uuid::generate(), 'name' => 'Vertex Electronics (Pvt.) Ltd.'],
                [ 'id' => Uuid::generate(), 'name' => 'Syed Bhais (Pvt.) Ltd.'],
                [ 'id' => Uuid::generate(), 'name' => 'IMS (Pvt.) Ltd.'],
                [ 'id' => Uuid::generate(), 'name' => 'Pak Elektron Limited'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
