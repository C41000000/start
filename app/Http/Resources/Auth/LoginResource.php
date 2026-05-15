<?php

declare(strict_types=1);

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

final class LoginResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'token' => $this['token'],
            'token_type' => $this['token_type'],
        ];
    }
}
