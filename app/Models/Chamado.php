<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chamado extends Model
{
     use HasFactory;

    protected $table = 'chamado';

    protected $fillable = [
        'titulo',
        'discricao',
        'prioridade_id',
        'anexo',      
    ];

    public function Propriedade(): BelongsTo
    {
        return $this->belongsTo(Auxprioridade::class, 'prioridade_id', 'id');
    }
}
