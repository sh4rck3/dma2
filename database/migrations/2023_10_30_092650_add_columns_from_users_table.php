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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->nullable()->after('password');
            $table->string('extension')->nullable()->after('status');
            $table->string('jobtitle')->nullable()->after('extension');
            $table->string('sector')->nullable()->after('jobtitle');
            $table->string('document')->nullable()->after('sector');
            $table->string('birthday')->nullable()->after('document');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'extension',
                'jobtitle',
                'sector',
                'document',
                'birthday',
            ]);
        });
    }
};
