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
        Schema::create('income_abstracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('income_teams')->cascadeOnDelete();
            $table->string('subtheme', 50);          // Renewable energy, dst
            $table->text('title');
            $table->string('abstract_path', 255);
            $table->string('commitment_path', 255);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_abstracts');
    }
};
