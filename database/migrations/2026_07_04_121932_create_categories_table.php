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
        Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name', 150)->unique();
        $table->string('slug', 150)->unique();
        $table->string('image')->nullable();
        $table->integer('sort_order')->default(0); // Để admin kéo thả vị trí hiển thị
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('categories');
    }
};
