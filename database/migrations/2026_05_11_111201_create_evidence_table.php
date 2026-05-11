<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evidence', function (Blueprint $table) {
            $table->id();

            $table->foreignId('case_id')
                ->constrained()
                ->onDelete('cascade');

            $table->text('description');

            $table->string('image_path')
                ->nullable();

            $table->json('key_object_area')
                ->nullable();

            $table->enum('type', ['image', 'text', 'report'])
                ->default('image');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidence');
    }
};