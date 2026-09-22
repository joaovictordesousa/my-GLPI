<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chamado extends Model
{
     use HasFactory;

    protected $table = 'chamado';

    protected $fillable = [
        'titulo',
        'discricao',
        'prioridade_id',
        'anexo',      
        'tecnico_id',
        'usuario_id',
        'status',
        'encerrado_por',
    ];

    protected function casts(): array
    {
        return [
            'atendido_em' => 'datetime',
            'encerrado_em' => 'datetime',
        ];
    }

    public function Propriedade(): BelongsTo
    {
        return $this->belongsTo(Auxprioridade::class, 'prioridade_id', 'id');
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function mensagens(): HasMany
    {
        return $this->hasMany(MensagemChamado::class, 'chamado_id');
    }
}
