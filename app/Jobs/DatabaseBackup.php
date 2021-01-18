<?php

namespace App\Jobs;

use App\Models\Database;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DatabaseBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Database $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->model = Database::where('id', $id)->firstOrFail();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $connection = ssh2_connect($this->model->host, $this->model->port);
        ssh2_auth_password($connection, $this->model->user, $this->model->password);

        $stream = ssh2_exec($connection, 'pwd');
        var_dump($stream);
    }
}
