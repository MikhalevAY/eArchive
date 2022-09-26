<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $title
 * @property string $type
 */
class Dictionary extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type'];
}
