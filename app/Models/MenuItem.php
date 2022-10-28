<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $title
 * @property integer $number
 * @property string $url
 * @method static Builder|MenuItem query()
 */
class MenuItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['title', 'number', 'url'];
}
