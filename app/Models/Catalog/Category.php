<?php

namespace App\Models\Catalog;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string $name
 * @property string $description
 * @property bool $is_active
 * @property int $sort_order
 */
class Category extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'sort_order',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
