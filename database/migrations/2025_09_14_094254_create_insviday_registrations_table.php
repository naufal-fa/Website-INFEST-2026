<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('insviday_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('full_name', 120);
            $table->string('whatsapp', 20);
            $table->string('school', 150);
            $table->string('batch', 20); // BATCH 1/2/3
            $table->date('visit_date');
            $table->string('payment_method', 20)->nullable();
            $table->json('docs')->nullable(); // paths: student_card, payment_proof, follow_infest, follow_ti
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('docs_submitted_at')->nullable();
            $table->timestamps();

            $table->unique('user_id'); // 1 pendaftar per akun
        });
    }
    public function down(): void {
        Schema::dropIfExists('insviday_registrations');
    }
};
