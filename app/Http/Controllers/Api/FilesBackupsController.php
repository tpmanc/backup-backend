<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\ApiFilesBackups;
use App\Models\FilesBackups;
use Illuminate\Http\Request;

class FilesBackupsController
{
    public function all(Request $request)
    {
        $id = $request->get('id');

        $result = [];
        /** @var FilesBackups[] $models */
        $models = FilesBackups::where('files_id', $id)->get();
        foreach ($models as $model) {
            $result[] = (new ApiFilesBackups($model))->getJson();
        }

        return $result;
    }
}
