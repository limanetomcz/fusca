<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLog;
use Illuminate\Http\Request;
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
        ]);

        if (!Schema::hasTable($validated['table'])) {
            return response()->json(['error' => 'Invalid table name'], 400);
        }

        ProcessLog::dispatch($validated);

        return response()->json(['status' => 'Log queued for processing'], 201);
    }
}
