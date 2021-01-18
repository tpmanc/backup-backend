<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Files
 * @package App\Models
 * @property int $id
 * @property int $server_id
 * @property string $path
 */
class Files extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = [
        'server_id',
        'path',
    ];
}
