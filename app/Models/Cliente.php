<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    // Colunas que podem ser preenchidas em massa
    protected $fillable = [
        'cpf',
        'nome',
        'data',
        'valor',
        'fase',
        'ho',
        'credor',
        'colchao'
    ];

    // Mantém timestamps habilitados
    public $timestamps = true;
}