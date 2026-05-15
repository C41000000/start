<?php

namespace App\Actions\Catalog\Products;

use App\Models\Catalog\Product;

final readonly class StoreAction
{
    public function __construct(private Product $product){}

    /**
     * @param array $data
     * @return Product
     */
    public function execute(array $data): Product
    {
        return $this->product->create($data);
    }
}
