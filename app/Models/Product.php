<?php

namespace App\Models;

use App\Models\Mark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'resume', 'description', 'routeImage', 'urlTechnical', 'mark_id'];

    public function mark()
    {
        return $this->belongsTo(Mark::class);
    }
}
