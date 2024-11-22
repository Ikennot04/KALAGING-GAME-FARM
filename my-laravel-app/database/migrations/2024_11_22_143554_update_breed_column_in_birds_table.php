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
        Schema::table('birds', function (Blueprint $table) {
            $table->renameColumn('breed', 'produc_id');
            
            $table->string('breed', 50)->nullable();  
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('birds', function (Blueprint $table) {
            // Re-add the unique constraint on the 'breed' column if necessary
            $table->unique('breed');
        });
    }
};
