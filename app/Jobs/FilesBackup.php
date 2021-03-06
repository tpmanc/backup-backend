<?php

namespace App\Jobs;

use App\Events\FilesBackupReady;
use App\Models\Files;
use App\Models\FilesBackups;
use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class FilesBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Files $model;
    private Server $server;

    /**
     * Create a new job instance.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->model = Files::where('id', $id)->firstOrFail();
        $this->server = Server::where('id', $this->model->server_id)->firstOrFail();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $folder = "/tmp/{$this->server->id}/{$this->model->id}/";
        $command = "rsync -chavzP -e 'sshpass -p \"{$this->server->password}\" ssh -o \"StrictHostKeyChecking no\" -p {$this->server->port}' {$this->server->user}@{$this->server->host}:/var/www/kesha-sugar/ $folder";
        shell_exec($command);

        echo "Rsync finished\n";

        $date = date('d_m_Y_H_i');
        $fileName = "$date.tar.gz";
        $path = storage_path('app');
        $storagePath = "{$this->server->id}/{$this->model->id}";
        $command = "tar -czvf {$path}/{$storagePath}/$fileName $folder";
        shell_exec($command);
        echo "Archive created: $date.tar.gz \n";

        $backup = new FilesBackups();
        $backup->files_id = $this->model->id;
        $backup->name = $fileName;
        $backup->path = "{$path}/{$storagePath}";
        $backup->save();

        event(
            new FilesBackupReady($backup)
        );
    }
}
