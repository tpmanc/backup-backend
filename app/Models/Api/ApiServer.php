<?php

namespace App\Models\Api;

use App\Models\Server;

class ApiServer
{
    private Server $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function getJson()
    {
        return [
            'id' => $this->server->id,
            'host' => $this->server->host,
            'user' => $this->server->user,
            'password' => $this->server->password,
            'port' => $this->server->port,
        ];
    }
}
