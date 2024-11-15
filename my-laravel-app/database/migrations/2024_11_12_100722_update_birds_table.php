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
            $table->renameColumn('product_id', 'breed');
            $table->renameColumn('category', 'owner');
            $table->string('handler', 50)->nullable();  
            $table->string('image', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('birds', function (Blueprint $table) {
            //
        });
    }
};
