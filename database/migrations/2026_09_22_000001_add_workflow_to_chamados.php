<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tipo')->default('usuario')->after('email');
        });

        Schema::table('chamado', function (Blueprint $table) {
            $table->foreignId('usuario_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->string('status')->default('aberto')->after('anexo');
            $table->foreignId('encerrado_por')->nullable()->after('atendido_em')->constrained('users')->nullOnDelete();
            $table->timestamp('encerrado_em')->nullable()->after('encerrado_por');
        });

        Schema::create('mensagens_chamado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamado_id')->constrained('chamado')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('mensagem')->nullable();
            $table->string('anexo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensagens_chamado');
        Schema::table('chamado', function (Blueprint $table) {
            $table->dropForeign(['usuario_id', 'encerrado_por']);
            $table->dropColumn(['usuario_id', 'status', 'encerrado_por', 'encerrado_em']);
        });
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('tipo'));
    }
};
