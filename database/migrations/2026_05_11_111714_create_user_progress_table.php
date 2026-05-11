<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('case_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->integer('score')
                ->default(0);

            $table->integer('opened_evidence')
                ->default(0);

            $table->integer('questions_used')
                ->default(0);

            $table->boolean('completed')
                ->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};