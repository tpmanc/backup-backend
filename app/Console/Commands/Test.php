<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Files;
use App\Models\Server;
use App\Components\Backup\MysqlBackup;
use App\Components\Backup\MysqlFactory;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        event(
            new \App\Events\TestEvent()
        );
        die();
        // $user = User::where('id', 1)->first();
        // $user->password = bcrypt('lergjlwkjglsjlajsdf');
        // $user->save();
        // die();
        $id = 1;
        $model = Files::where('id', $id)->firstOrFail();
        $server = Server::where('id', $model->server_id)->firstOrFail();
        $folder = '/tmp/ks-backup/';

        $command = "rsync -chavzP -e 'sshpass -p \"{$server->password}\" ssh -o \"StrictHostKeyChecking no\" -p {$server->port}' {$server->user}@{$server->host}:/var/www/kesha-sugar/ $folder";
        shell_exec($command);

        echo "Rsync finished\n";

        $date = date('d_m_Y_H_i');
        $command = "tar -czvf /tmp/$date.tar.gz $folder";
        shell_exec($command);
        echo "Archive created: $date.tar.gz \n";

        return 0;
    }
}
