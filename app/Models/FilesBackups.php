<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FilesBackups
 * @package App\Models
 * @property int $id
 * @property int $files_id
 * @property string $name
 * @property string $path
 * @property-read Files $files
 */
class FilesBackups extends Model
{
    use HasFactory;

    protected $table = 'files_backups';

    protected $fillable = [
        'files_id',
        'name',
        'path',
    ];

    public function files()
    {
        return $this->belongsTo(Files::class);
    }
}
