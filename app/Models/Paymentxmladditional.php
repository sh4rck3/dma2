<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentxmladditional extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_paymentxmls',
        'aditional_cpf',
        'descricaoverba1',
        'valor1',
        'percentual1',
        'basecalculo1',
    ];
}
