<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $logo
 * @property string $color
 */
class SystemSetting extends Model
{
    use HasFactory;

    public static array $defaultColors = [
        '#DC2F2F',
        '#F35C50',
        '#F2722C',
        '#FD9C12',
        '#FFB400',
        '#83B81D',
        '#08A826',
        '#0AA360',
        '#00AEA0',
        '#12B2E7',
        '#2196E0',
        '#257DE3',
        '#0065AE',
        '#5555DC',
        '#7A4CD9',
        '#A447BF',
        '#DA3B64',
        '#D2334D',
    ];

    protected $fillable = ['logo', 'color'];
}
