<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            if (!Schema::hasColumn('solicitudes', 'publicada_at')) {
                $table->timestamp('publicada_at')->nullable()->after('updated_at');
            }
            if (!Schema::hasColumn('solicitudes', 'publicada_por')) {
                $table->unsignedBigInteger('publicada_por')->nullable()->after('publicada_at');
                // Si quieres FK real (opcional, coméntalo si no tienes users):
                $table->foreign('publicada_por')->references('id')->on('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            if (Schema::hasColumn('solicitudes', 'publicada_por')) {
                $table->dropForeign(['publicada_por']);
                $table->dropColumn('publicada_por');
            }
            if (Schema::hasColumn('solicitudes', 'publicada_at')) {
                $table->dropColumn('publicada_at');
            }
        });
    }
};

