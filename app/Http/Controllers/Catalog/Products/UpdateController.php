<?php

declare(strict_types=1);

namespace App\Http\Controllers\Catalog\Products;

use App\Actions\Catalog\Products\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Products\UpdateProductRequest;
use App\Http\Resources\Catalog\Products\ProductResource;
use App\Models\Catalog\Product;
use Dedoc\Scramble\Attributes\Group;

#[Group('Products', weight: 2)]
final class UpdateController extends Controller
{
    /**
     * Atualizar Produto
     * @param string $uuid
     * @param UpdateProductRequest $request
     * @param UpdateAction $action
     * @return ProductResource
     * @authenticated
     */
    public function __invoke(string $uuid, UpdateProductRequest $request, UpdateAction $action): ProductResource
    {
        $this->authorize('update', Product::class);

        return new ProductResource($action->execute($uuid, $request->validated()));
    }
}
