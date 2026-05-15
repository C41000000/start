<?php

declare(strict_types=1);

namespace App\Models\Catalog;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $uuid
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property string|null $image_url
 * @property string $unit_type
 * @property string $print_location
 * @property bool $manage_stock
 * @property float $stock_quantity
 * @property bool $is_active
 *
 * @property-read Category $category
 */
class Product extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image_url',
        'unit_type',
        'print_location',
        'manage_stock',
        'stock_quantity',
        'is_active',
    ];

    /**
     * Relacionamento: Um produto pertence a uma categoria.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
