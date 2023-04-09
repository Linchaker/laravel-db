<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Book.
 *
 * @property string $_id
 * @property string $title
 * @property string $content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Book extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'books';

    protected $fillable = [
        'title',
        'content',
    ];
}
