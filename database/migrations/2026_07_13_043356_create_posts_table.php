<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề bài viết
            $table->string('slug')->unique(); // Tối ưu SEO
            $table->text('content'); // Nội dung chính

            // Lưu mảng 1-4 ảnh dưới dạng JSON: ["img1.jpg", "img2.jpg", ...]
            // Cách này giúp truy vấn cực nhanh, không cần JOIN bảng trung gian
            $table->json('images')->nullable();

            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable(); // Để lên lịch đăng bài
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
