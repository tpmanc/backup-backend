<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\ApiDatabase;
use App\Models\Database;
use App\Models\Project;
use App\Models\Server;
use App\Jobs\DatabaseBackup;
use Illuminate\Http\Request;

class DatabaseController
{
    public function all(Request $request)
    {
        $serverId = $request->get('serverId');

        $result = [];
        /** @var Database[] $models */
        $models = Database::where('server_id', $serverId)->get();
        foreach ($models as $model) {
            $result[] = (new ApiDatabase($model))->getJson();
        }

        return $result;
    }

    public function get(int $id)
    {
        /** @var Database $model */
        $model = Database::where('id', $id)->firstOrFail();

        return (new ApiDatabase($model))->getJson();
    }

    public function save(Request $request)
    {
        $id = $request->post('id');
        if ($id == 0) {
            $model = new Database();
        } else {
            $model = Database::where('id', $id)->firstOrFail();
        }

        /** @var Server $server */
        $server = Server::where('id', $request->post('serverId'))->firstOrFail();

        $model->server_id = $server->id;
        $model->user = $request->post('user');
        $model->password = $request->post('password');
        $model->database = $request->post('database');

        if (!$model->save()) {
            throw new \Exception('error');
        }

        return (new ApiDatabase($model))->getJson();
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        /** @var Database $model */
        $model = Database::where('id', $id)->firstOrFail();
        $model->delete();

        return [
            'id' => $id,
        ];
    }

    public function run(Request $request)
    {
        $id = $request->post('id');
        /** @var Database $model */
        $model = Database::where('id', $id)->firstOrFail();

        DatabaseBackup::dispatch($model->id);

        return [];
    }
}
