<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    if (!Schema::hasTable('solicitudes')) {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('trailer_url')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->text('sinopsis')->nullable();
            $table->enum('estado', ['pendiente','aprobada','rechazada'])->default('pendiente');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('revisado_por')->nullable();
            $table->text('nota_revisor')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    } else {
        // si ya existe pero le faltan columnas (por si venías de 'solicituds')
        Schema::table('solicitudes', function (Blueprint $table) {
            foreach ([
              'nombre' => fn()=> $table->string('nombre')->after('id'),
              'trailer_url' => fn()=> $table->string('trailer_url')->nullable(),
              'poster_path' => fn()=> $table->string('poster_path')->nullable(),
              'banner_path' => fn()=> $table->string('banner_path')->nullable(),
              'sinopsis' => fn()=> $table->text('sinopsis')->nullable(),
              'estado' => fn()=> $table->enum('estado',['pendiente','aprobada','rechazada'])->default('pendiente'),
              'user_id' => fn()=> $table->unsignedBigInteger('user_id')->nullable(),
              'revisado_por' => fn()=> $table->unsignedBigInteger('revisado_por')->nullable(),
              'nota_revisor' => fn()=> $table->text('nota_revisor')->nullable(),
            ] as $col => $adder) {
                if (!Schema::hasColumn('solicitudes', $col)) { $adder(); }
            }
        });
    }
}


};
