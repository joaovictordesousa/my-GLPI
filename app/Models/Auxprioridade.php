<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auxprioridade extends Model
{
    use HasFactory;

    protected $table = 'auxprioridades';

    protected $fillable = [
        'status',
    ];

    Public function Chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class, 'prioridade', 'id');
    }
}

