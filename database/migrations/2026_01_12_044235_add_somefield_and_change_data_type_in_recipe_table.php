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
        Schema::table('recipe', function (Blueprint $table) {
            $table->text('how_to_cook');
            $table->text('description')->change();
            $table->text('ingredients')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe', function (Blueprint $table) {
            $table->string('ingredients')->change();
            $table->string('description')->change();
            $table->dropColumn('how_to_cook');
           
        });
    }
};
