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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string("email", 100)->unique();
            $table->string("user_name", 100)->unique();
            $table->date("birthday");
            $table->string('first_name', 100);
            $table->string("last_name", 100);
            $table->string("password");
            $table->string("reset_password")->nullable();
            $table->integer("status");
            $table->boolean("flag_delete")->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
