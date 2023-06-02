<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;

class Menu extends Model implements Auditable
{
    use HasFactory;
    use  \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'slug', 'parent', 'order', 'enabled', 'image', 'content',  'subtitle', 'template_id', 'logo', 'mark_id'];

    public function parentMenu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent')->withDefault([
            'name' => $this->name,
        ]);
    }

    public function orderMenu($parent)
    {
        return $this->query()->get()->where('parent', $parent)->count();
    }

    public function getElementsParentMenu($parent)
    {
        return $this->query()->get()->where('parent', $parent);
    }

    public function getIdByNamePage(string $slug)
    {
        return $this->query()->get()->where('slug', $slug)->first();
    }

    public function galleries(): BelongsToMany
    {
        return $this->belongsToMany(Gallery::class);
    }

    public function advantages(): BelongsToMany
    {
        return $this->belongsToMany(Advantage::class);
    }

    public function template()
    {
        return $this->hasOne(Template::class, 'id', 'template_id');
    }

    public function mark()
    {
        return $this->belongsTo(Mark::class);
    }
}
