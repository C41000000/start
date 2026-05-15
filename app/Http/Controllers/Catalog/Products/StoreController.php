<?php

namespace App\Http\Controllers\Catalog\Products;

use App\Actions\Catalog\Products\StoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Products\StoreProductRequest;
use App\Http\Resources\Catalog\Products\ProductResource;
use App\Models\Catalog\Product;
use Dedoc\Scramble\Attributes\Group;

#[Group('Products', weight: 2)]
final class StoreController extends Controller
{
    /**
     * Criar novo produto
     *
     * Registra um novo produto no catálogo. É necessário vincular a uma categoria existente
     * e possuir a permissão `product.create`.
     * * @authenticated
     */
    public function __invoke(StoreProductRequest $request, StoreAction $action): ProductResource
    {
        $this->authorize('create', Product::class);

        $product = $action->execute($request->validated());

        return new ProductResource($product);
    }
}
