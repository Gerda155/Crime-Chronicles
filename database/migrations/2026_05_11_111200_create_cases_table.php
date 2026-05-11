<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description');

            $table->foreignId('genre_id')
                ->constrained()
                ->onDelete('cascade');

            $table->integer('rating')->default(0);

            $table->unsignedBigInteger('answer_id')->nullable();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('status')->default('active');

            $table->boolean('is_tutorial')->default(false);

            $table->text('solution_explanation')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};