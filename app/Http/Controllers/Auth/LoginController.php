<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use Dedoc\Scramble\Attributes\Group;

#[Group('Autenticacion', weight: 1)]
final class LoginController
{
    /**
     *  Realizar Login
     *
     *  Autentica o usuário no sistema utilizando e-mail e senha.
     *  Retorna um JWT (JSON Web Token) que deve ser enviado no header `Authorization` nas próximas requisições.
     *
     * @param LoginRequest $request
     * @param LoginAction $action
     * @return LoginResource
     * @unautheticated
     */
    public function __invoke(LoginRequest $request, LoginAction $action)
    {
        return new LoginResource($action->execute($request->validated()));
    }
}
