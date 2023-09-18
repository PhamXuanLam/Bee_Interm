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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('email',100)->nullable()->unique();
            $table->string('phone', 20)->unique();
            $table->date('birthday');
            $table->string('full_name', 100);
            $table->string('password');
            $table->string('reset_password')->nullable();
            $table->string('address', 255);
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('commune_id');
            $table->integer('status');
            $table->boolean('flag_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
