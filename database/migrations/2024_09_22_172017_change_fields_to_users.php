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
        Schema::table('users', function (Blueprint $table) {            
            $table->text('bio')->change(); // Change column type from string to text
            $table->dateTime('birth_date')->change(); // Change column type from string to datetime
        });
    }       
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bio')->change(); // Change back to string
            $table->string('birth_date')->change(); // Change back to string or appropriate type
        });
    }
};
