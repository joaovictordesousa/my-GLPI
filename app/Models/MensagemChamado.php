<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensagemChamado extends Model
{
    use HasFactory;

    protected $table = 'mensagens_chamado';

    protected $fillable = ['chamado_id', 'user_id', 'mensagem', 'anexo'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
