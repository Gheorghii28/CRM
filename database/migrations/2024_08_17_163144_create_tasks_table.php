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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deal_id')->nullable()->constrained('deals')->onDelete('cascade');
            $table->string('title', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('task_description')->collation('utf8mb4_unicode_ci');
            $table->date('due_date')->nullable();
            $table->enum('status', ['to-do', 'in-progress', 'done'])->collation('utf8mb4_unicode_ci')->default('to-do');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
