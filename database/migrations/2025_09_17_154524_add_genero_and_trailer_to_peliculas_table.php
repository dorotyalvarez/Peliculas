<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::table('peliculas', function (Blueprint $table) {
        $table->string('genero')->nullable()->after('titulo');
        $table->string('trailer')->nullable()->after('imagen'); // link a YouTube, por ejemplo
    });
}

public function down(): void
{
    Schema::table('peliculas', function (Blueprint $table) {
        $table->dropColumn(['genero', 'trailer']);
    });
}
};
