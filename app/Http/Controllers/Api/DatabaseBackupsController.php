<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\ApiDatabaseBackups;
use App\Models\DatabaseBackups;
use Illuminate\Http\Request;

class DatabaseBackupsController
{
    public function all(Request $request)
    {
        $id = $request->get('id');

        $result = [];
        /** @var DatabaseBackups[] $models */
        $models = DatabaseBackups::where('database_id', $id)->get();
        foreach ($models as $model) {
            $result[] = (new ApiDatabaseBackups($model))->getJson();
        }

        return $result;
    }
}
