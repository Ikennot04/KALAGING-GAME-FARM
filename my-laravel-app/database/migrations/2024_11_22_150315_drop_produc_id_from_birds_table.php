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
           
            $table->dropColumn('produc_id'); // Drop the column
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('birds', function (Blueprint $table) {
            // Re-add the produc_id column with a unique constraint
            $table->string('produc_id', 15)->unique();
        });
    }
};
