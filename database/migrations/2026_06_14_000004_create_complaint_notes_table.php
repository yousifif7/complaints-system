<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_type_id')->constrained('form_types')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note');
            $table->string('type')->default('internal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_notes');
    }
};
