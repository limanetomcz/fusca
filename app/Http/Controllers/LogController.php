<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'level' => 'required|string',
        'message' => 'required|string',
        'context' => 'nullable|string',
        'author' => 'string',
        'ip' => 'string',
    ]);

    ProcessLog::dispatch($validated);

    return response()->json(['status' => 'Log queued for processing'], 201);
}
}
