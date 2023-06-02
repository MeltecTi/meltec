<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function successCases()
    {
        return $this->hasMany(SuccessCase::class);
    }
}
