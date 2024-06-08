<?php

namespace App\Jobs;

use Carbon\Carbon;
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

        $prohibitedTables = [
            'cache', 'cache_locks', 'failed_jobs', 'job_batches',
            'jobs', 'logs', 'migrations', 'password_reset_tokens',
            'sessions', 'users'
        ];

        if (!in_array($tableName, $prohibitedTables)) {
            $currentTimestamp = Carbon::now()->toDateTimeString();
            $this->data['created_at'] = $currentTimestamp;
            $this->data['updated_at'] = $currentTimestamp;
            DB::table($tableName)->insert($this->data);
        }
    }
}
