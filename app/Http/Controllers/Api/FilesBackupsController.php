<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\ApiFilesBackups;
use App\Models\FilesBackups;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function download(Request $request)
    {
        $id = $request->get('id');
        $backup = FilesBackups::where('id', $id)->first();
        $url = Storage::url("{$backup->path}/{$backup->name}");

        return new JsonResponse(
            [
                'url' => $url,
            ]
        );
    }
}
