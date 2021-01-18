<?php

namespace App\Models\Api;

use App\Models\Database;

class ApiDatabase
{
    private Database $model;

    public function __construct(Database $model)
    {
        $this->model = $model;
    }

    public function getJson()
    {
        return [
            'id' => $this->model->id,
            'user' => $this->model->user,
            'password' => $this->model->password,
            'database' => $this->model->database,
        ];
    }
}
