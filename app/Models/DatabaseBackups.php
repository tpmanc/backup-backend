<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DatabaseBackups
 * @package App\Models
 * @property int $id
 * @property int $database_id
 * @property string $name
 * @property string $path
 * @property-read Database $database
 */
class DatabaseBackups extends Model
{
    use HasFactory;

    protected $table = 'database_backups';

    protected $fillable = [
        'database_id',
        'name',
        'path',
    ];

    public function database()
    {
        return $this->belongsTo(Database::class);
    }
}
