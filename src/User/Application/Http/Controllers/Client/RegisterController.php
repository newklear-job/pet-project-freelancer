<?php

namespace Freelance\User\Application\Http\Controllers\Client;

use Freelance\User\Domain\Actions\Contracts\RegistersUserAction;
use Freelance\User\Domain\Dtos\RegisterDto;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class RegisterController
{
    public function store(
        Request             $request,
        RegistersUserAction $action
    ): JsonResponse {
        $dto = RegisterDto::create(
            $request->input('email'),
            $request->input('name'),
            $request->input('password'),
            $request->input('password_confirmation'),
        );
        $user = $action->run($dto);
        event(new Registered($user));
        $token = $user->createToken('default');
        return response()->json(['token' => $token->plainTextToken]);
    }
}
