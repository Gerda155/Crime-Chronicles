<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->comment('Lietas nosaukums');
            $table->text('description')->comment('Īss gadījuma apraksts');
            $table->text('preview')->comment('Kopsavilkums par lietu pirms izmeklēšanas sākuma');
            $table->foreignId('genre_id')->constrained('genres')->comment('Žanrs, izvēlēts no iepriekš definētas žanru tabulas');
            $table->integer('rating')->default(0)->comment('Sākotnējā vērtība 0, mainās pēc lietotāju aktivitātes');
            $table->string('answer')->comment('Pareizā risinājuma vārds vai frāze');
            $table->timestamps(); // created_at и updated_at
        });
        
    }
    
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }

    
};
