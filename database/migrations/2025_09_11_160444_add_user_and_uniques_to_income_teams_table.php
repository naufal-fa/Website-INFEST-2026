<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('income_teams', function (Blueprint $table) {
            // Tambah kolom user_id
            if (!Schema::hasColumn('income_teams', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained('users')->cascadeOnDelete();
            }
            // Tambah constraint unik (pastikan tidak ada duplikat sebelum migrate)
            $table->unique('user_id');
            $table->unique('team_name');
            $table->unique('leader_email');
        });
    }
    public function down(): void {
        Schema::table('income_teams', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
            $table->dropUnique(['team_name']);
            $table->dropUnique(['leader_email']);
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
