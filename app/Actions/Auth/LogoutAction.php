<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

final readonly class LogoutAction
{
    /**
     * @return void
     */
    public function execute(): void
    {
        Auth::guard('api')->logout();
    }
}
