<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Drop the existing capacity column
            $table->dropColumn('capacity');

            // Add a new category_image column
            $table->string('category_image')->nullable(); // Allow null initially
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Restore the capacity column if needed
            $table->integer('capacity')->nullable();
            // Drop the category_image column
            $table->dropColumn('category_image');
        });
    }
};