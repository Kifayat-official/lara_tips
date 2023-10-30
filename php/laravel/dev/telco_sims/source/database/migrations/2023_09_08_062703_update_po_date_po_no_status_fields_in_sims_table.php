<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sims', function (Blueprint $table) {
            // Change the default value of po_date to NULL and make it nullable
            $table->datetime('po_date')->nullable()->default(null)->change();

            // Change the default value of po_no to NULL and make it nullable
            $table->string('po_no', 250)->nullable()->default(null)->change();

            // Change the default value of status to 1
            $table->tinyInteger('status')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('sims', function (Blueprint $table) {
        //     //
        // });
    }
};
