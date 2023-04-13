<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;

class Advantage extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    
    protected $fillable = ['title', 'content'];

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class);
    }
}
