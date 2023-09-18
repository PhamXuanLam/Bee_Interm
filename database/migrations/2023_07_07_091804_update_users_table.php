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
        Schema::table('users', function (Blueprint $table) {
            $table->string('address', 255);
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('commune_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns("address");
        Schema::dropColumns("province_id");
        Schema::dropColumns("district_id");
        Schema::dropColumns("commune_id");
    }
};
