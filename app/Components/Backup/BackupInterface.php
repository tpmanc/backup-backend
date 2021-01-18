<?php

namespace App\Components\Backup;

use App\Models\Server;

interface BackupInterface
{
    public function run(): void;
}
