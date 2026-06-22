<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->string('codigo', 3)->primary();
            $table->string('nome');
        });

        DB::table('clientes')->insert([
            ['codigo' => '167', 'nome' => 'arapiraca'],
            ['codigo' => '081', 'nome' => 'ilheus'],
            ['codigo' => '078', 'nome' => 'itabuna'],
            ['codigo' => '030', 'nome' => 'feira'],
            ['codigo' => '112', 'nome' => 'serido'],
            ['codigo' => '036', 'nome' => 'recife'],
            ['codigo' => '088', 'nome' => 'caruaru'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
