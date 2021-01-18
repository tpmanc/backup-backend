<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\ApiFiles;
use App\Models\Files;
use App\Models\Server;
use App\Jobs\FilesBackup;
use Illuminate\Http\Request;

class FilesController
{
    public function all(Request $request)
    {
        $serverId = $request->get('serverId');

        $result = [];
        /** @var Files[] $models */
        $models = Files::where('server_id', $serverId)->get();
        foreach ($models as $model) {
            $result[] = (new ApiFiles($model))->getJson();
        }

        return $result;
    }

    public function get(int $id)
    {
        /** @var Files $model */
        $model = Files::where('id', $id)->firstOrFail();

        return (new ApiFiles($model))->getJson();
    }

    public function save(Request $request)
    {
        $id = $request->post('id');
        if ($id == 0) {
            $model = new Files();
        } else {
            $model = Files::where('id', $id)->firstOrFail();
        }

        /** @var Server $server */
        $server = Server::where('id', $request->post('serverId'))->firstOrFail();

        $model->server_id = $server->id;
        $model->path = $request->post('path');

        if (!$model->save()) {
            throw new \Exception('error');
        }

        return (new ApiFiles($model))->getJson();
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        /** @var Files $model */
        $model = Files::where('id', $id)->firstOrFail();
        $model->delete();

        return [
            'id' => $id,
        ];
    }

    public function run(Request $request)
    {
        $id = $request->post('id');
        /** @var Files $model */
        $model = Files::where('id', $id)->firstOrFail();

        FilesBackup::dispatch($model->id);

        return [];
    }
}
