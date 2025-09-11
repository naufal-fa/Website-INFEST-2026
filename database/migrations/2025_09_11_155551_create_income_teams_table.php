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
        Schema::create('income_teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_name', 100);
            $table->string('leader_name', 100);
            $table->string('member_name', 100)->nullable();
            $table->string('school', 150);
            $table->string('leader_whatsapp', 20);
            $table->string('leader_email', 150);
            $table->string('requirements_link', 255);
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();

            $table->index(['leader_email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_teams');
    }
};
