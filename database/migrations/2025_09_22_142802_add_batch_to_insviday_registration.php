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
        Schema::table('insviday_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('insviday_registrations','visit_date')) {
                $table->date('visit_date')->nullable()->after('school');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insviday_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('insviday_registrations','visit_date')) $table->dropColumn('visit_date');
        });
    }
};
