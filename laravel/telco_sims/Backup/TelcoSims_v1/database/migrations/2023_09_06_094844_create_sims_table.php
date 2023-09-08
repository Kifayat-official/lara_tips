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
        Schema::create('sims', function (Blueprint $table) {
            $table->id();
            $table->string('sim_id', 250)->collation('utf8mb4_general_ci');
            $table->string('sim_no', 15)->collation('utf8mb4_general_ci');
            $table->string('telco_name', 30)->collation('utf8mb4_general_ci');
            $table->string('disco_name', 30)->collation('utf8mb4_general_ci');
            $table->string('po_no', 250)->collation('utf8mb4_general_ci');
            $table->datetime('po_date');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sims');
    }
};
