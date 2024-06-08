<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLog;
use Illuminate\Database\Schema\Blueprint;
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

        $table = $validated['table'];
        
        if (!Schema::hasTable($table)) {
            Schema::create($table, function (Blueprint $table) {
                $table->bigIncrements('id');
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
}
