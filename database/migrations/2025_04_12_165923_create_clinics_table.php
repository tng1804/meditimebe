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
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);          // Tên phòng khám
            $table->text('address');              // Địa chỉ phòng khám
            $table->string('phone', 20);          // Số điện thoại
            $table->string('email', 255)->nullable(); // Email liên hệ (có thể null)
            $table->timestamps();                 // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
