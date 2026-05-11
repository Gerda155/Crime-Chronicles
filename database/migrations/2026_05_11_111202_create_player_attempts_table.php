<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('player_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('case_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('suspect_id')
                ->constrained()
                ->onDelete('cascade');

            $table->boolean('is_correct');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_attempts');
    }
};