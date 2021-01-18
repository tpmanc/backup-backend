<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Server
 * @package App\Models
 * @property int $id
 * @property int $project_id
 * @property string $host
 * @property string $user
 * @property string $password
 * @property string $port
 */
class Server extends Model
{
    use HasFactory;

    protected $table = 'server';

    protected $fillable = [
        'project_id',
        'host',
        'user',
        'password',
        'port',
    ];
}
