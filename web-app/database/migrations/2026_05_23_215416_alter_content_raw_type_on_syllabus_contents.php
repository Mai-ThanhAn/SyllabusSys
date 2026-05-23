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
        Schema::table('syllabus_contents', function (Blueprint $table) {
            $table->jsonb('content_raw')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syllabus_contents', function (Blueprint $table) {
            // Rollback: đổi lại kiểu dữ liệu cũ (ví dụ text)
            $table->text('content_raw')->nullable()->change();
        });
    }
};
