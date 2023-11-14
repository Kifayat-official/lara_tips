<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perms', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');

            $table->string('group');
            $table->string('idt');
            $table->string('parent_idt')->nullable();
            $table->string('name');
            $table->string('order')->nullable();

            CommonMigrations::five($table);
        });

        CommonMigrations::insertEntityPermissions('perms', 'Roles Management', 1, 'Role', 'role', 's');
        CommonMigrations::insertEntityPermissions('perms', 'Users Management', 2, 'User', 'user', 's');
        CommonMigrations::insertEntityPermissions('perms', 'Companies Management', 3, 'Company', 'company', 'ies');
        
        CommonMigrations::insertEntityPermissions('perms', 'UDIL Tests Management', 4, 'UDIL Test', 'udil_test', 's');
        CommonMigrations::insertPermission('perms', 'UDIL Tests Management', 5, 'Take Test', 'take_test', null);
        CommonMigrations::insertPermission('perms', 'UDIL Tests Management', 6, 'Finish Test', 'finish_test', null);
        
        CommonMigrations::insertEntityPermissions('perms', 'UDIL Checklists Management', 7, 'UDIL Checklist', 'udil_checklist', 's');

        CommonMigrations::insertPermission('perms', 'Reports', 8, 'Test Report', 'test_report', null);
        CommonMigrations::insertPermission('perms', 'Reports', 9, 'Detailed Test Report', 'detailed_test_report', null);

        CommonMigrations::insertPermission('perms', 'Reports', 10, 'Test Certificate', 'test_certificate', null);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perms');
    }
}
