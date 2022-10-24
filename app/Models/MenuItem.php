<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $title
 * @property integer $number
 * @property string $url
 */
class MenuItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['title', 'number', 'url'];
}
