<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brand_category', function (Blueprint $table) {

            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->primary(['category_id', 'brand_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_category');
    }
};
