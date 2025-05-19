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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('action', 255); // Hành động (create, update, delete, ...)
            $table->string('model', 255); // Đối tượng (patient, medical_record, ...)
            $table->unsignedBigInteger('model_id'); // ID của đối tượng bị ảnh hưởng
            $table->text('details')->nullable(); // Chi tiết hành động (JSON hoặc text)
            $table->timestamps();

            // Khóa ngoại với bảng users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
