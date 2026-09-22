<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chamado', function (Blueprint $table) {
            $table->foreignId('tecnico_id')
                ->nullable()
                ->after('prioridade_id')
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('atendido_em')->nullable()->after('tecnico_id');
        });
    }

    public function down(): void
    {
        Schema::table('chamado', function (Blueprint $table) {
            $table->dropForeign(['tecnico_id']);
            $table->dropColumn(['tecnico_id', 'atendido_em']);
        });
    }
};
