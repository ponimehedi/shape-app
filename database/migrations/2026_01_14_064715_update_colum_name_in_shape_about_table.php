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
        Schema::table('shape_about', function (Blueprint $table) {

             $table->renameColumn('about me', 'about_me');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shape_about', function (Blueprint $table) {
             $table->renameColumn('about_me', 'about me');
        });
    }
};
