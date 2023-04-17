<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BaseWeb extends Model implements Auditable
{
    use HasFactory;
    use  \OwenIt\Auditing\Auditable;
    protected $table = 'base_web';
    protected $fillable = ['component', 'content', 'type_component'];

    public function getContentByName(string $component) 
    {
        $content = $this->query()->get()->where('component', $component)->first();
        return $content->content;
    }
}
