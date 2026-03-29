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
        Schema::create('workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->integer('sets')->default(3);
            $table->integer('reps')->nullable(); // nullable for cardio exercises
            $table->integer('duration_seconds')->nullable(); // for cardio/stretching
            $table->integer('rest_seconds')->default(60); // rest between sets
            $table->integer('order')->default(1); // order in the workout
            $table->timestamps();

            $table->unique(['workout_id', 'exercise_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_exercises');
    }
};
