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
        // Nhân viên lễ tân
        Schema::create('receptionists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // 1:1 với bảng users
            $table->string('phone', 20)->nullable();
            $table->timestamps();
            // Thiết lập khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receptionists');
    }
};
