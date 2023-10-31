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
        Schema::create('paymentxmls', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('payment_shipping')->nullable();
            $table->string('cpf')->nullable();
            $table->string('mesRef')->nullable();
            $table->string('recibo')->nullable();
            $table->string('empresa')->nullable();
            $table->string('setor')->nullable();
            $table->string('endereco')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('funcionario')->nullable();
            $table->string('dataadm')->nullable();
            $table->string('ferias')->nullable();
            $table->string('valorTC')->nullable();
            $table->string('valorTD')->nullable();
            $table->string('valorTL')->nullable();
            $table->string('valorFa')->nullable();
            $table->string('mensagemc1')->nullable();
            $table->string('valorFGTS')->nullable();
            $table->string('valorBaseIRRF')->nullable();
            $table->string('valorBaseINNS')->nullable();
            $table->string('valorSalarioBase')->nullable();
            $table->string('valorBaseFGTS')->nullable();
            $table->string('dataAssinatura')->nullable();
            $table->string('assinado')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentxmls');
    }
};
