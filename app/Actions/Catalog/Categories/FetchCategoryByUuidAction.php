<?php

declare(strict_types=1);

namespace App\Actions\Catalog\Categories;

use App\Models\Catalog\Category;

final readonly class FetchCategoryByUuidAction
{
    public function __construct(private Category $category) {}

    /**
     * @param string $uuid
     * @return mixed
     */
    public function execute(string $uuid)
    {
        return $this->category->where('uuid', $uuid)->firstOrFail();
    }
}
