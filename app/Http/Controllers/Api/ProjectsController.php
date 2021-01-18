<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\ApiProject;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController
{
    public function all()
    {
        $result = [];
        /** @var Project[] $models */
        $models = Project::get();
        foreach ($models as $model) {
            $result[] = (new ApiProject($model))->getJson();
        }

        return $result;
    }

    public function get(int $id)
    {
//        $id = $request->get('id');

        /** @var Project $model */
        $model = Project::where('id', $id)->firstOrFail();

        return (new ApiProject($model))->getJson();
    }

    public function save(Request $request)
    {
        $id = $request->post('id');
        if ($id == 0) {
            $model = new Project();
        } else {
            $model = Project::where('id', $id)->firstOrFail();
        }
        $model->title = $request->post('title');
        if (!$model->save()) {
            throw new \Exception('error');
        }

        return (new ApiProject($model))->getJson();
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        /** @var Project $model */
        $model = Project::where('id', $id)->firstOrFail();
        $model->delete();

        return [
            'id' => $id,
        ];
    }
}
