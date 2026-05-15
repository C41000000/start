<?php

declare(strict_types=1);

namespace App\Http\Controllers\Catalog\Products;

use App\Actions\Catalog\Products\DestroyAction;
use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Response;

#[Group('Products', weight: 2)]
class DestroyController extends Controller
{
    /**
     * Deletar Produto
     * @param string $uuid
     * @param DestroyAction $action
     * @return Response
     */
    public function __invoke(string $uuid, DestroyAction $action): Response
    {
        $this->authorize('delete', Product::class);
        $action->execute($uuid);

        return response()->noContent();
    }
}
