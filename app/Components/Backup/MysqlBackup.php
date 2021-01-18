<?php

namespace App\Components\Backup;

use App\Models\Server;

class MysqlBackup implements BackupInterface
{
    public function __construct(
        protected Server $server,
    ) {}

    public function run(): void
    {
        var_dump('mysql');
        throw new \Exception();
    }
}
