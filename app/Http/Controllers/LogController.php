<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLog;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LogController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'operation' => 'required|string',
            'old_data' => 'nullable|string',
            'new_data' => 'nullable|string',
            'author' => 'required|string',
            'ip' => 'nullable|string',
            'table' => 'required|string',
            'cliente' => 'required|string|size:3|exists:clientes,codigo',
        ]);

        $table = $validated['table'];
        
        if (!Schema::hasTable($table)) {
            Schema::create($table, function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('cliente', 3);
                $table->foreign('cliente')->references('codigo')->on('clientes');
                $table->string('author');
                $table->string('ip')->nullable();
                $table->timestamps();
                $table->string('operation')->nullable();
                $table->text('new_data')->nullable();
                $table->text('old_data')->nullable();
            });
        }

        ProcessLog::dispatch($validated);

        return response()->json(['status' => 'Log queued for processing'], 201);
    }

    public function getLog(Request $request)
    {
        $validated = $request->validate([
            'table' => 'required|string|regex:/^[a-zA-Z0-9_]+$/',
            'date_start' => 'required|date',
            'date_finish' => 'required|date|after_or_equal:date_start',
            'author' => 'nullable|string|max:255',
            'cliente' => 'nullable|string|size:3|exists:clientes,codigo',
        ]);

        if (!Schema::hasTable($validated['table'])) {
            return response()->json(['error' => 'Tabela de log não encontrada'], 404);
        }

        $query = DB::table($validated['table'])
            ->whereBetween('created_at', [
                $validated['date_start'] . ' 00:00:00',
                $validated['date_finish'] . ' 23:59:59',
            ]);

        if (!empty($validated['author'])) {
            $query->where('author', 'like', '%' . $validated['author'] . '%');
        }

        if (!empty($validated['cliente'])) {
            $query->where('cliente', $validated['cliente']);
        }

        $results = $query->orderByDesc('created_at')->get();

        return response()->json($results);
    }

    public function listTables()
    {
        $tables = collect(DB::select('SHOW TABLES'))
            ->map(fn ($row) => array_values((array) $row)[0])
            ->filter(fn ($table) => str_starts_with($table, 'uniodtb_'))
            ->sort()
            ->values();

        return response()->json($tables);
    }
}
