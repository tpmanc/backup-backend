<?php

namespace App\Models\Api;

use App\Models\Project;

class ApiProject
{
    private Project $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function getJson()
    {
        return [
            'id' => $this->project->id,
            'title' => $this->project->title,
        ];
    }
}
