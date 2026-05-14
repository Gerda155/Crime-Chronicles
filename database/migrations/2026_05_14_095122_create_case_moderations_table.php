<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_moderations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('case_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('moderator_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->enum('status', [
                'approved',
                'rejected'
            ]);

            $table->text('comment')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_moderations');
    }
};