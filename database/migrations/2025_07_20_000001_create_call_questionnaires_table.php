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
        Schema::create('call_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('call_script_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->boolean('is_active')->default(true);
            $table->json('questions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_questionnaires');
    }
}; 