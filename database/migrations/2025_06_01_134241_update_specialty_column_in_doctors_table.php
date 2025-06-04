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
        Schema::table('doctors', function (Blueprint $table) {
            // Xóa cột specialty cũ nếu tồn tại
            if (Schema::hasColumn('doctors', 'specialty')) {
                $table->dropColumn('specialty');
            }

            // Thêm khóa ngoại specialty_id
            $table->unsignedBigInteger('specialty_id')->after('user_id');

            $table->foreign('specialty_id')
                  ->references('id')
                  ->on('specialties')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['specialty_id']);
            $table->dropColumn('specialty_id');

            // Có thể thêm lại cột `specialty` nếu muốn khôi phục
            $table->string('specialty')->nullable();
        });
    }
};
