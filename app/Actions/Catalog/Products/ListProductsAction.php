<?php

declare(strict_types=1);

namespace App\Actions\Catalog\Products;

use App\Models\Catalog\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

final readonly class ListProductsAction
{
    public function __construct(private Product $product) {}

    public function execute(array $filters = []): LengthAwarePaginator
    {

        return $this->product->query()
            ->with('category')
            ->when(Arr::get($filters, 'search'), function ($query, $search) {
                $query->where('name', 'ilike', "%{$search}%")
                    ->orWhere('description', 'ilike', "%{$search}%");
            })
            ->when(Arr::get($filters, 'category_id'), fn ($q, $id) => $q->where('category_id', $id))
            ->orderBy(
                Arr::get($filters, 'sort_by', 'name'),
                Arr::get($filters, 'sort_order', 'asc')
            )
            ->paginate(Arr::get($filters, 'per_page', 15));
    }
}
