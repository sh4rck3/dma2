<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->string('cod_escritorio')->nullable();
            $table->string('nome_escritorio')->nullable();
            $table->string('recolhi_bra_outr')->nullable();
            $table->string('num_remessa')->nullable();
            $table->string('num_gcpj')->nullable();
            $table->string('uf')->nullable();
            $table->string('num_processo')->nullable();
            $table->string('acao_ajuizada')->nullable();
            $table->string('reu_autor')->nullable();
            $table->string('empresa_banco')->nullable();
            $table->string('nome_cliente')->nullable();
            $table->string('cpf_cnpj')->nullable();
            $table->string('ndbqcng')->nullable();
            $table->string('cdbqcng')->nullable();
            $table->string('agencia')->nullable();
            $table->string('conta')->nullable();
            $table->string('contrato')->nullable();
            $table->string('descricao_despesas')->nullable();
            $table->string('valor')->nullable();
            $table->string('carteira')->nullable();
            $table->string('quant_dias')->nullable();
            $table->string('distancia')->nullable();
            $table->string('codigo_barras')->nullable();
            $table->string('tipo_guia')->nullable();
            $table->string('data_vencimento')->nullable();
            $table->string('duplicidade')->nullable();
            $table->string('justifi_duplicidade')->nullable();
            $table->string('responsavel')->nullable();
            $table->string('tipoArquivo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financials');
    }
};
