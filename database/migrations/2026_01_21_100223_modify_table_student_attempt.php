<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('student_attempt', function (Blueprint $table) {
            $table->datetime('result_at')->nullable()->after('submit_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_attempt', function (Blueprint $table) {
            $table->dropColumn(['result_at']);
        });
    }
};
