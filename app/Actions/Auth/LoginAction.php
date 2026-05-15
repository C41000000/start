<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final readonly class LoginAction
{
    /**
     * @param array $credentials
     * @return array
     */
    public function execute(array $credentials): array
    {

        $token = Auth::guard('api')->attempt($credentials);

        if (! $token) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return [
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }
}
