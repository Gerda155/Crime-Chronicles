<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('cases')->onDelete('cascade')->comment('Связь с делом');
            $table->text('description')->comment('Īss pierādījuma vai aizdomīgā apraksts');
            $table->string('image_path')->comment('Attēls, kas ilustrē pierādījumu vai aizdomīgo personu, atļautie formāti JPG un PNG');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidence');
    }
};
