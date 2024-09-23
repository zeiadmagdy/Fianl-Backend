<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(0); // Add is_admin column
        });
    }
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin'); // Drop is_admin column
        });
    }
};