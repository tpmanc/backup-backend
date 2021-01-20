<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Database
 * @package App\Models
 * @property int $id
 * @property int $server_id
 * @property string $user
 * @property string $password
 * @property string $database
 * @property-read Server $server
 */
class Database extends Model
{
    use HasFactory;

    protected $table = 'databases';

    protected $fillable = [
        'server_id',
        'user',
        'password',
        'database',
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
