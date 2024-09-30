<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePointsTableLatitudeLongitude extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('points', function (Blueprint $table) {
            // Remove the 'location' field (Google Maps URL)
            $table->dropColumn('location');

            // Add 'latitude' and 'longitude' fields
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
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
            // Re-add the 'location' field if needed in future rollback
            $table->string('location')->nullable();

            // Remove 'latitude' and 'longitude' fields
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
}
