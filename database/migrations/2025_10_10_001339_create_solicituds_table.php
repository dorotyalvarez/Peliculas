<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('solicitudes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('trailer_url')->nullable();
        $table->string('poster_path')->nullable(); // storage/public/solicitudes/posters/...
        $table->string('banner_path')->nullable(); // storage/public/solicitudes/banners/...
        $table->text('sinopsis')->nullable();

        $table->enum('estado', ['pendiente','aprobada','rechazada'])->default('pendiente');
        $table->unsignedBigInteger('user_id')->nullable();     // quién pidió
        $table->unsignedBigInteger('revisado_por')->nullable(); // quién revisó
        $table->text('nota_revisor')->nullable();

        $table->timestamps();
        $table->softDeletes();

        // Si más adelante usas users:
        // $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        // $table->foreign('revisado_por')->references('id')->on('users')->nullOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('solicitudes');
}


};
