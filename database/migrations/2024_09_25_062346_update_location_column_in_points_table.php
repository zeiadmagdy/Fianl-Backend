<?php

// database/migrations/xxxx_xx_xx_update_location_column_in_points_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLocationColumnInPointsTable extends Migration
{
    public function up()
    {
        Schema::table('points', function (Blueprint $table) {
            $table->string('location', 1000)->change();
        });
    }

    public function down()
    {
        Schema::table('points', function (Blueprint $table) {
            $table->string('location', 255)->change();
        });
    }
}
