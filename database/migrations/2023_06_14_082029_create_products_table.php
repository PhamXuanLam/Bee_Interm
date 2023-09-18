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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id");
            $table->string("sku", 20)->unique();
            $table->string('name', 255);
            $table->integer('stock');
            $table->string("avatar", 255);
            $table->date("expired_at");
            $table->integer("category_id")->nullable();
            $table->boolean("flag_delete")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
