<?php

namespace App\Jobs;

use App\Models\Files;
use App\Models\FilesBackups;
use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FilesBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Files $model;
    private Server $server;

    /**
     * Create a new job instance.
     *
     * @return void
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
        $command = "tar -czvf /tmp/$fileName $folder";
        shell_exec($command);
        echo "Archive created: $date.tar.gz \n";

        $backup = new FilesBackups();
        $backup->files_id = $this->model->id;
        $backup->name = $fileName;
        $backup->path = '/tmp/';
        $backup->save();
    }
}
