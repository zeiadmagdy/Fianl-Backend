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
        Schema::table('points', function (Blueprint $table) {
            //change values of longitude column and latitude column
            $table->decimal('longitude', 40, 30)->change();
            $table->decimal('latitude', 40, 30)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('points', function (Blueprint $table) {
            $table->decimal('longitude', 14, 10)->change();
            $table->decimal('latitude', 14, 10)->change();
        });
    }
};
