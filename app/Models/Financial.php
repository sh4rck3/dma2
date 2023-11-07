<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod_escritorio',
        'nome_escritorio',
        'recolhi_bra_outr',
        'num_remessa',
        'num_gcpj',
        'uf',
        'num_processo',
        'acao_ajuizada',
        'reu_autor',
        'empresa_banco',
        'nome_cliente',
        'cpf_cnpj',
        'ndbqcng',
        'cdbqcng',
        'agencia',
        'conta',
        'contrato',
        'descricao_despesas',
        'valor',
        'carteira',
        'quant_dias',
        'distancia',
        'codigo_barras',
        'tipo_guia',
        'data_vencimento',
        'duplicidade',
        'justifi_duplicidade',
        'responsavel',
        'tipoArquivo',

    ];
}
