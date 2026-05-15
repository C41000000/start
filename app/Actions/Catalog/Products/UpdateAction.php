<?php

declare(strict_types=1);

namespace App\Actions\Catalog\Products;

use App\Actions\Catalog\Categories\FetchCategoryByUuidAction;
use App\Models\Catalog\Product;

final readonly class UpdateAction
{
    public function __construct(
        private Product $product,
        private FetchCategoryByUuidAction $fetchCategoryByUuidAction,
    ) {}

    /**
     * @param string $uuid
     * @param array $data
     * @return mixed
     */
    public function execute(string $uuid, array $data): Product
    {
        $product = $this->product->where('uuid', $uuid)->first();
        $category = $this->fetchCategoryByUuidAction->execute($data['category_id']);

        abort_if(! $product, 404, 'product not found');

        $data['category_id'] = $category->id;
        $product->update($data);

        return $product;
    }
}
