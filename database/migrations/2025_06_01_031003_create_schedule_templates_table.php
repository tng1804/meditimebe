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
        Schema::create('schedule_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên mẫu (có thể dùng làm mô tả)
            $table->tinyInteger('day_of_week'); // 1 (Thứ 2) đến 7 (Chủ nhật)
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->unsignedBigInteger('template_group_id'); // Khóa ngoại
            $table->timestamps();

            $table->foreign('template_group_id')
                  ->references('id')->on('schedule_template_groups')
                  ->onDelete('cascade'); // Xóa nhóm sẽ xóa tất cả các khung giờ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_templates');
    }
};
