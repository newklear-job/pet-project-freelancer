<?php

namespace Freelance\User\Application\Http\Controllers;

use Freelance\User\Domain\Actions\Contracts\LoginsUserAction;
use Freelance\User\Domain\Actions\Contracts\LogoutsUserAction;
use Freelance\User\Domain\Dtos\LoginDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LogoutResponse;

final class LoginController
{
    public function store(
        Request          $request,
        LoginsUserAction $action
    ): JsonResponse {
        $loginDto = LoginDto::create($request->input('email'), $request->input('password'));
        $token = $action->run($loginDto);
        return response()->json(['token' => $token->plainTextToken]);
    }

    public function destroy(Request $request, LogoutsUserAction $action): LogoutResponse
    {
        $action->run($request->user());
        return app(LogoutResponse::class);
    }
}
