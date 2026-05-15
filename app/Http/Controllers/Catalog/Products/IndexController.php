<?php

namespace App\Http\Controllers\Catalog\Products;

use App\Actions\Catalog\Products\ListProductsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Catalog\Products\ListProductsRequest;
use App\Http\Resources\Catalog\Products\ProductResource;
use App\Models\Catalog\Product;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('Products', weight: 3)]
final class IndexController extends Controller
{

    /**
     * Lista Produtos
     *
     * @param ListProductsRequest $request
     * @param ListProductsAction $action
     * @return AnonymousResourceCollection
     *
     */
    public function __invoke(ListProductsRequest $request, ListProductsAction $action)
    {
        $this->authorize('viewAny', Product::class);

        return ProductResource::collection($action->execute($request->validated()));
    }
}
