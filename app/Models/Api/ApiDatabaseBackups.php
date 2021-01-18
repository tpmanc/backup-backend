<?php

namespace App\Models\Api;

use App\Models\DatabaseBackups;

class ApiDatabaseBackups
{
    private DatabaseBackups $model;

    public function __construct(DatabaseBackups $model)
    {
        $this->model = $model;
    }

    public function getJson()
    {
        return [
            'id' => $this->model->id,
            'name' => $this->model->name,
            'path' => $this->model->path,
        ];
    }
}
