<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('useer_score', function (Blueprint $table) {
                $table->id();

                // Who attempted the quiz (user)
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

                // Which quiz they attempted
                $table->unsignedBigInteger('quiz_id');
                $table->foreign('quiz_id')->references('id')->on('quizzes')->cascadeOnDelete();

                // Score info
                $table->integer('total_questions'); // total number of questions in quiz
                $table->integer('correct_answers'); // number of correct answers
                $table->float('percentage')->nullable(); // accuracy % if needed
                $table->integer('score')->nullable(); // total score, can be weighted
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('useer_score');
    }
};
