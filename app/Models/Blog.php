<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class Blog extends Model implements Auditable
{
    use HasFactory;
    use  \OwenIt\Auditing\Auditable;

    protected $table = 'blogs';
    
    protected $fillable = ['title', 'content', 'user_id', 'category_id', 'image'];

    public function category() : HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
