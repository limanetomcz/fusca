<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $systemTables = [
        'cache', 'cache_locks', 'failed_jobs', 'job_batches',
        'jobs', 'migrations', 'password_reset_tokens',
        'sessions', 'users', 'personal_access_tokens', 'clientes',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->getLogTables() as $tableName) {
            if (Schema::hasColumn($tableName, 'cliente')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->string('cliente', 3)->default('167')->after('id');
            });

            DB::table($tableName)->update(['cliente' => '167']);

            Schema::table($tableName, function (Blueprint $table) {
                $table->foreign('cliente')->references('codigo')->on('clientes');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->getLogTables() as $tableName) {
            if (!Schema::hasColumn($tableName, 'cliente')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['cliente']);
                $table->dropColumn('cliente');
            });
        }
    }

    private function getLogTables(): array
    {
        $databaseName = DB::getDatabaseName();

        return collect(DB::select(
            'SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?',
            [$databaseName]
        ))
            ->pluck('TABLE_NAME')
            ->filter(fn (string $name) => !in_array($name, $this->systemTables))
            ->filter(fn (string $name) => Schema::hasColumn($name, 'author'))
            ->values()
            ->all();
    }
};
