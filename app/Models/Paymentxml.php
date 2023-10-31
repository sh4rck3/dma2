<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentxml extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_shipping',
        'cpf',
        'mesRef',
        'recibo',
        'empresa',
        'setor',
        'endereco',
        'cnpj',
        'funcionario',
        'dataadm',
        'ferias',
        'valorTC',
        'valorTD',
        'valorTL',
        'valorFa',
        'mensagemc1',
        'valorFGTS',
        'valorBaseIRRF',
        'valorBaseINNS',
        'valorSalarioBase',
        'valorBaseFGTS',
        'dataAssinatura',
        'assinado',
        'status',
    ];

    protected $primaryKey = 'id';

    public function paymentxmladditionalsr()
    {
        return $this->hasMany(Paymentxmladditional::class, 'id_paymentxmls', 'id');
    }
}
