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
        Schema::create('paymentxmladditionals', function (Blueprint $table) {
            $table->id();
            $table->string('id_paymentxmls')->nullable();
            $table->string('aditional_cpf')->nullable();
            $table->string('descricaoverba1')->nullable();
            $table->string('valor1')->nullable();
            $table->string('percentual1')->nullable();
            $table->string('basecalculo1')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentxmladditionals');
    }
};
