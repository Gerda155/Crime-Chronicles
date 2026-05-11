<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rangs', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->integer('min_score');
            $table->integer('max_score')
                ->nullable();

            $table->string('status', 20)
                ->default('active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rangs');
    }
};