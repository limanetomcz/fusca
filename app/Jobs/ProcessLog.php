<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $logData;
    /**
     * Create a new job instance.
     */
    public function __construct($logData)
    {
        $this->logData = $logData;
    }
    
    public function handle()
    {
        \App\Models\Log::create($this->logData);
    }
}
