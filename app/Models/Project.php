<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * @package App\Models
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 */
class Project extends Model
{
    use HasFactory, Timestamp;

    protected $table = 'projects';

    protected $fillable = [
        'title',
    ];
}
