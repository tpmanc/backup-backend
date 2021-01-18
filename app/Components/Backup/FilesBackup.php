<?php

namespace App\Components\Backup;

use App\Models\Server;

class FilesBackup implements BackupInterface
{
    public function __construct(
        protected Server $server,
    ) {}

    public function run(): void
    {
        shell_exec("rsync -zavP {$this->server->user}@{$this->server->host}:/backup /backup/file1/");
    }
}
