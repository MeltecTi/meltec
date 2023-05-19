<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'businessUnit',
        'goal',
        'goalPercent',
        'goalDirector',
        'goalDirectorPercent',
        'goalCommercial',
        'commercialPercent',
        'q1Percent',
        'q2Percent',
        'q3Percent',
        'q4Percent',
        'q1',
        'q2',
        'q3',
        'q4',
    ];
}
