<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Financial;

class FinancialImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    //public function collection(Collection $row)
    public function model(array $row)
    {
        return new Financial([
            'cod_escritorio' => $row[0],
            'nome_escritorio' => $row[1],
            'recolhi_bra_outr' => $row[2],
            'num_remessa' => $row[3],
            'num_gcpj' => $row[4],
            'uf' => $row[5],
            'num_processo' => $row[6],
            'acao_ajuizada' => $row[7],
            'reu_autor' => $row[8],
            'empresa_banco' => $row[9],
            'nome_cliente' => $row[10],
            'cpf_cnpj' => $row[11],
            'ndbqcng' => $row[12],
            'cdbqcng' => $row[13],
            'agencia' => $row[14],
            'conta' => $row[15],
            'contrato' => $row[16],
            'descricao_despesas' => $row[17],
            'valor' => $row[18],
            'carteira' => $row[19],
            'quant_dias' => $row[20],
            'distancia' => $row[21],
            'codigo_barras' => $row[22],
            'tipo_guia' => $row[23],
            'data_vencimento' => $row[24],
            'duplicidade' => $row[25],
            'justifi_duplicidade' => $row[26],
            'responsavel' => $row[27],
            'tipoArquivo' => $row[28]
        ]);
    }
}
