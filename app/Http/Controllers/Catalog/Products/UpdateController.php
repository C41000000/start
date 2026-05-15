<?php

declare(strict_types=1);

namespace App\Http\Controllers\Catalog\Products;

use App\Actions\Catalog\Products\UpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Products\UpdateProductRequest;
use App\Http\Resources\Catalog\Products\ProductResource;
use App\Models\Catalog\Product;

final class UpdateController extends Controller
{
    public function __invoke(string $uuid, UpdateProductRequest $request, UpdateAction $action)
    {
        $this->authorize('update', Product::class);

        return new ProductResource($action->execute($uuid, $request->validated()));
    }
}
