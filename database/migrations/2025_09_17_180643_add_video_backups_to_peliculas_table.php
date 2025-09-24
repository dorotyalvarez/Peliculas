<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('peliculas', function (Blueprint $table) {
        // $table->string('video_url')->nullable()->after('trailer'); ❌ ya existe
        $table->string('video_backup')->nullable()->after('video_url'); // ✅ solo este
    });
}

public function down(): void
{
    Schema::table('peliculas', function (Blueprint $table) {
        $table->dropColumn(['video_backup']);
    });
}
};
