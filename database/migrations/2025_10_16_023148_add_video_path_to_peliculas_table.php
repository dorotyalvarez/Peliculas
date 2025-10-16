<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('peliculas', function (Blueprint $table) {
        $table->string('video_path')->nullable()->after('video_url'); // ruta relativa tipo "videos/xxx.mp4"
    });
}
public function down()
{
    Schema::table('peliculas', function (Blueprint $table) {
        $table->dropColumn('video_path');
    });
}
};
