<?php

namespace App\Models;

use App\Models\Mark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuccessCase extends Model
{
    use HasFactory;

    protected $fillable = ['caseneed', 'caseneedContent', 'caseSolution', 'caseSolutionContent', 'caseResult', 'caseResultContent', 'mark_id'];

    public function mark()
    {
        return $this->belongsTo(Mark::class);
    }
}
