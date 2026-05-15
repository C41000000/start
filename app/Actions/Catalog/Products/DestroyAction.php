<?php

declare(strict_types=1);

namespace App\Actions\Catalog\Products;

use App\Models\Catalog\Product;

final readonly class DestroyAction
{
    public function __construct(private Product $product) {}

    /**
     * Deletar Produto
     * @param string $uuid
     * @return void
     * @authenticated
     */
    public function execute(string $uuid): void
    {
        $product = $this->product->where('uuid', $uuid)->first();

        abort_if(! $product, 404, 'Product not found');

        $product->delete();
    }
}
