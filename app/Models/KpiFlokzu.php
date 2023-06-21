<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiFlokzu extends Model
{
    use HasFactory;

    protected $table = 'kpi_flokzu';
    protected $fillable = ['form_reference_id', 'date_created', 'name', 'director_email', 'observations', 'kpi_name', 'period', 'percent'];
}
