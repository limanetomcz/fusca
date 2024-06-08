<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tableName = $this->data['table'];
        unset($this->data['table']);
        $this->data['created_at'] = date('Y-m-d H:i:s');
        $this->data['updated_at'] = date('Y-m-d H:i:s');
        DB::table($tableName)->insert($this->data);
    }
}
