<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('suspects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('case_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('name');
            $table->text('description');

            $table->string('image_path')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suspects');
    }
};