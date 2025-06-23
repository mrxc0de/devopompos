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
        Schema::create('task_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_links');
    }
};
