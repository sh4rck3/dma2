<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Codedddstate;

class CodedddstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codedddstate = [
            [ 
                'region' => 'Centro-Oeste',
                'state' => 'Distrito Federal',
                'ddd' => 61 
            ],
            [ 'region' => 'Centro-Oeste', 'state' => 'Goiás', 'ddd' => 61 ],
            [ 'region' => 'Centro-Oeste', 'state' => 'Goiás', 'ddd' => 62 ],
            [ 'region' => 'Centro-Oeste', 'state' => 'Goiás', 'ddd' => 64 ],
            [ 'region' => 'Centro-Oeste', 'state' => 'Mato Grosso', 'ddd' => 65 ],
            [ 'region' => 'Centro-Oeste', 'state' => 'Mato Grosso', 'ddd' => 66 ],
            [ 'region' => 'Centro-Oeste', 'state' => 'Mato Grosso do Sul', 'ddd' => 67 ],
            [ 'region' => 'Nordeste', 'state' => 'Alagoas', 'ddd' => 82 ],
            [ 'region' => 'Nordeste', 'state' => 'Bahia', 'ddd' => 71 ],
            [ 'region' => 'Nordeste', 'state' => 'Bahia', 'ddd' => 73 ],
            [ 'region' => 'Nordeste', 'state' => 'Bahia', 'ddd' => 74 ],
            [ 'region' => 'Nordeste', 'state' => 'Bahia', 'ddd' => 75 ],
            [ 'region' => 'Nordeste', 'state' => 'Bahia', 'ddd' => 77 ],
            [ 'region' => 'Nordeste', 'state' => 'Ceará', 'ddd' => 85 ],
            [ 'region' => 'Nordeste', 'state' => 'Ceará', 'ddd' => 88 ],
            [ 'region' => 'Nordeste', 'state' => 'Maranhão', 'ddd' => 98 ],
            [ 'region' => 'Nordeste', 'state' => 'Maranhão', 'ddd' => 99 ],
            [ 'region' => 'Nordeste', 'state' => 'Paraíba', 'ddd' => 83 ],
            [ 'region' => 'Nordeste', 'state' => 'Pernambuco', 'ddd' => 81 ],
            [ 'region' => 'Nordeste', 'state' => 'Pernambuco', 'ddd' => 87 ],
            [ 'region' => 'Nordeste', 'state' => 'Piauí', 'ddd' => 86 ],
            [ 'region' => 'Nordeste', 'state' => 'Piauí', 'ddd' => 89 ],
            [ 'region' => 'Nordeste', 'state' => 'Rio Grande do Norte', 'ddd' => 84 ],
            [ 'region' => 'Nordeste', 'state' => 'Sergipe', 'ddd' => 79 ],
            [ 'region' => 'Norte', 'state' => 'Acre', 'ddd' => 68 ],
            [ 'region' => 'Norte', 'state' => 'Amapá', 'ddd' => 96 ],
            [ 'region' => 'Norte', 'state' => 'Amazonas', 'ddd' => 92 ],
            [ 'region' => 'Norte', 'state' => 'Amazonas', 'ddd' => 97 ],
            [ 'region' => 'Norte', 'state' => 'Pará', 'ddd' => 91 ],
            [ 'region' => 'Norte', 'state' => 'Pará', 'ddd' => 93 ],
            [ 'region' => 'Norte', 'state' => 'Pará', 'ddd' => 94 ],
            [ 'region' => 'Norte', 'state' => 'Rondônia', 'ddd' => 69 ],
            [ 'region' => 'Norte', 'state' => 'Roraima', 'ddd' => 95 ],
            [ 'region' => 'Norte', 'state' => 'Tocantins', 'ddd' => 63 ],
            [ 'region' => 'Sudeste', 'state' => 'Espírito Santo', 'ddd' => 27 ],
            [ 'region' => 'Sudeste', 'state' => 'Espírito Santo', 'ddd' => 28 ],
            [ 'region' => 'Sudeste', 'state' => 'Minas Gerais', 'ddd' => 31 ],
            [ 'region' => 'Sudeste', 'state' => 'Minas Gerais', 'ddd' => 32 ],
            [ 'region' => 'Sudeste', 'state' => 'Minas Gerais', 'ddd' => 33 ],
            [ 'region' => 'Sudeste', 'state' => 'Minas Gerais', 'ddd' => 34 ],
            [ 'region' => 'Sudeste', 'state' => 'Minas Gerais', 'ddd' => 35 ],
            [ 'region' => 'Sudeste', 'state' => 'Minas Gerais', 'ddd' => 37 ],
            [ 'region' => 'Sudeste', 'state' => 'Minas Gerais', 'ddd' => 38 ],
            [ 'region' => 'Sudeste', 'state' => 'Rio de Janeiro', 'ddd' => 21 ],
            [ 'region' => 'Sudeste', 'state' => 'Rio de Janeiro', 'ddd' => 22 ],
            [ 'region' => 'Sudeste', 'state' => 'Rio de Janeiro', 'ddd' => 24 ],
            [ 'region' => 'Sudeste', 'state' => 'São Paulo', 'ddd' => 11 ],
            [ 'region' => 'Sudeste', 'state' => 'São Paulo', 'ddd' => 12 ],
            [ 'region' => 'Sudeste', 'state' => 'São Paulo', 'ddd' => 13 ],
            [ 'region' => 'Sudeste', 'state' => 'São Paulo', 'ddd' => 14 ],
            [ 'region' => 'Sudeste', 'state' => 'São Paulo', 'ddd' => 15 ],
            [ 'region' => 'Sudeste', 'state' => 'São Paulo', 'ddd' => 16 ],
            [ 'region' => 'Sudeste', 'state' => 'São Paulo', 'ddd' => 17 ],
            [ 'region' => 'Sudeste', 'state' => 'São Paulo', 'ddd' => 18 ],
            [ 'region' => 'Sudeste', 'state' => 'São Paulo', 'ddd' => 19 ],
            [ 'region' => 'Sul', 'state' => 'Paraná', 'ddd' => 41 ],
            [ 'region' => 'Sul', 'state' => 'Paraná', 'ddd' => 42 ],
            [ 'region' => 'Sul', 'state' => 'Paraná', 'ddd' => 43 ],
            [ 'region' => 'Sul', 'state' => 'Paraná', 'ddd' => 44 ],
            [ 'region' => 'Sul', 'state' => 'Paraná', 'ddd' => 45 ],
            [ 'region' => 'Sul', 'state' => 'Paraná', 'ddd' => 46 ],
            [ 'region' => 'Sul', 'state' => 'Paraná', 'ddd' => 49 ],
            [ 'region' => 'Sul', 'state' => 'Rio Grande do Sul', 'ddd' => 51 ],
            [ 'region' => 'Sul', 'state' => 'Rio Grande do Sul', 'ddd' => 53 ],
            [ 'region' => 'Sul', 'state' => 'Rio Grande do Sul', 'ddd' => 54 ],
            [ 'region' => 'Sul', 'state' => 'Rio Grande do Sul', 'ddd' => 55 ],
            [ 'region' => 'Sul', 'state' => 'Santa Catarina', 'ddd' => 42 ],
            [ 'region' => 'Sul', 'state' => 'Santa Catarina', 'ddd' => 47 ],
            [ 'region' => 'Sul', 'state' => 'Santa Catarina', 'ddd' => 48 ],
            [ 'region' => 'Sul', 'state' => 'Santa Catarina', 'ddd' => 49 ]
        ];

        foreach ($codedddstate as $value) {
            Codedddstate::create([
                'region' => $value['region'],
                'state' => $value['state'],
                'ddd' => $value['ddd']
            ]);            
        }
    }
}
