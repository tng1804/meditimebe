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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('schedule_template_id');
            $table->timestamps();

            // Khóa ngoại liên kết tới bảng doctors
            $table->foreign('doctor_id')
                  ->references('id')->on('doctors')
                  ->onDelete('cascade');

            // Khóa ngoại liên kết tới bảng schedule_template_groups
            $table->foreign('schedule_template_id')
                  ->references('id')->on('schedule_template_groups')
                  ->onDelete('cascade');

            // Gợi ý thêm: Đảm bảo mỗi bác sĩ chỉ có 1 mẫu lịch tại 1 thời điểm
            $table->unique('doctor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
