<?php

namespace App\Models\Api;

use App\Models\Files;

class ApiFiles
{
    private Files $model;

    public function __construct(Files $model)
    {
        $this->model = $model;
    }

    public function getJson()
    {
        return [
            'id' => $this->model->id,
            'path' => $this->model->path,
        ];
    }
}
