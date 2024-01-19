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
        Schema::table('sendsms', function (Blueprint $table) {
            $table->renameColumn('response', 'result');
            $table->string('content')->before('result')->nullable();
            $table->string('port')->before('result')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sendsms', function (Blueprint $table) {
            $table->renameColumn('result', 'response');
            $table->dropColumn('content');
            $table->dropColumn('port');
        });
    }
};
