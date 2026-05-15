<?php

namespace App\Http\Resources\Catalog\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request):array
    {
        return [
            'uuid' => $this->uuid,
            'id' => $this->uuid,
            'name'=> $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category' => [
                'id' => $this->category->uuid,
                'name' => $this->category->name,
            ]
        ];
    }
}
