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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('pickup');
            $table->string('dropoff');
            $table->date('date');
            $table->decimal('distance', 8, 2);
            $table->enum('status', ['Pending', 'Underway', 'Done'])->default('Pending');
            $table->string('payment_method')->nullable(); // Added payment_method column
            $table->string('payment_id')->nullable();     // Added payment_id column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
