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
        Schema::table('receptionists', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('address')->nullable()->after('date_of_birth');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('address');
            $table->text('note')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receptionists', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'date_of_birth',
                'address',
                'status',
                'note'
            ]);
        });
    }
};
