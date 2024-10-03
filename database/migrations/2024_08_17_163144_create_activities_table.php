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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('deal_id')->constrained('deals')->onDelete('cascade');
            $table->enum('activity_type', ['Call', 'Meeting', 'Email', 'Presentation']);
            $table->text('activity_description')->nullable();
            $table->timestamp('date')->nullable();
            $table->enum('status', ['completed', 'pending', 'scheduled'])->nullable()->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->nullable()->default('low');
            $table->string('location', 255)->nullable();
            $table->string('outcome', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('reminder')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
