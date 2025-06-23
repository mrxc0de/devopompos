<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('task_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // Foreign keys
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();

            $table->string('status')->default('pending'); // pending, in_progress, completed
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->dateTime('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_lists');
    }
};
