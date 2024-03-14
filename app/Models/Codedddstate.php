<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codedddstate extends Model
{
    use HasFactory;

    protected $fillable = [
        'ddd',
        'state',
        'region'
    ];

    public static function dddlocate($ddd)
    {
        return Codedddstate::firstWhere('ddd', $ddd);
    }
}
