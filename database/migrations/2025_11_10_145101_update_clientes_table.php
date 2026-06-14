<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Adiciona apenas as colunas que ainda não existem
            if (!Schema::hasColumn('clientes', 'data')) {
                $table->date('data')->nullable()->after('nome');
            }
            if (!Schema::hasColumn('clientes', 'fase')) {
                $table->string('fase')->after('valor');
            }
            if (!Schema::hasColumn('clientes', 'ho')) {
                $table->string('ho')->after('fase');
            }
            if (!Schema::hasColumn('clientes', 'colchao')) {
                $table->string('colchao')->after('credor');
            }
            if (!Schema::hasColumn('clientes', 'acoes')) {
                $table->string('acoes')->after('colchao');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Remove as colunas adicionadas, se existirem
            if (Schema::hasColumn('clientes', 'data')) {
                $table->dropColumn('data');
            }
            if (Schema::hasColumn('clientes', 'fase')) {
                $table->dropColumn('fase');
            }
            if (Schema::hasColumn('clientes', 'ho')) {
                $table->dropColumn('ho');
            }
            if (Schema::hasColumn('clientes', 'colchao')) {
                $table->dropColumn('colchao');
            }
            if (Schema::hasColumn('clientes', 'acoes')) {
                $table->dropColumn('acoes');
            }
        });
    }
};