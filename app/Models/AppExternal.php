<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AppExternal extends Model 
{
    use HasFactory;

    protected $table = "external_applications";
    protected $fillable = ['application_name', 'client_id', 'client_secret'];
    
}
