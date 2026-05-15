<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LogoutAction;
use Dedoc\Scramble\Attributes\Group;

#[Group('Autenticacion', weight: 1)]
final class LogoutController
{
    public function __invoke(LogoutAction $action)
    {
        $action->execute();
        response()->noContent();
    }
}
