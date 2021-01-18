<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\ApiServer;
use App\Models\Project;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController
{
    public function all(Request $request)
    {
        $projectId = $request->get('projectId');

        $result = [];
        /** @var Server[] $models */
        $models = Server::where('project_id', $projectId)->get();
        foreach ($models as $model) {
            $result[] = (new ApiServer($model))->getJson();
        }

        return $result;
    }

    public function get(int $id)
    {
        /** @var Server $model */
        $model = Server::where('id', $id)->firstOrFail();

        return (new ApiServer($model))->getJson();
    }

    public function save(Request $request)
    {
        $id = $request->post('id');
        if ($id == 0) {
            $model = new Server();
        } else {
            $model = Server::where('id', $id)->firstOrFail();
        }

        /** @var Project $project */
        $project = Project::where('id', $request->post('projectId'))->firstOrFail();

        $model->project_id = $project->id;
        $model->host = $request->post('host');
        $model->user = $request->post('user');
        $model->password = $request->post('password');
        $model->port = $request->post('port');

        if (!$model->save()) {
            throw new \Exception('error');
        }

        return (new ApiServer($model))->getJson();
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        /** @var Server $model */
        $model = Server::where('id', $id)->firstOrFail();
        $model->delete();

        return [
            'id' => $id,
        ];
    }
}
