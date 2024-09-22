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
        $table->timestamps(); // This will add both `created_at` and `updated_at`
    });
}

public function down()
{
    Schema::table('categories', function (Blueprint $table) {
        $table->dropTimestamps(); // To rollback, remove the timestamps
    });
}

};
