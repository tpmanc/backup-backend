<?php

namespace App\Models\Api;

use App\Models\FilesBackups;

class ApiFilesBackups
{
    private FilesBackups $model;

    public function __construct(FilesBackups $model)
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
