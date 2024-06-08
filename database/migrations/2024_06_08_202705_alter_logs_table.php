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
        Schema::table('logs', function (Blueprint $table) {
            // Adicionar novas colunas
            $table->string('operation')->nullable();
            $table->text('new_data')->nullable();
            $table->text('old_data')->nullable();

            // Remover colunas
            $table->dropColumn('level');
            $table->dropColumn('message');
            $table->dropColumn('context');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn('operation');
            $table->dropColumn('new_data');
            $table->dropColumn('old_data');

            $table->string('level')->nullable();
            $table->text('message')->nullable();
            $table->string('context')->nullable();
        });
    }
};
