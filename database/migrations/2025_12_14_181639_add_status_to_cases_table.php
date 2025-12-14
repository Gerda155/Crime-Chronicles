<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('cases', function (Blueprint $table) {
        $table->string('status')->default('jauna')->after('genre_id'); // 'jauna', 'procesa', 'pabeigta'
    });
}

public function down()
{
    Schema::table('cases', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
