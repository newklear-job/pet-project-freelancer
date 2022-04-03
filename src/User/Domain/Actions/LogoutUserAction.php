<?php

namespace Freelance\User\Domain\Actions;

use Freelance\User\Domain\Actions\Contracts\LogoutsUserAction;
use Freelance\User\Domain\Models\User;
use Illuminate\Validation\ValidationException;

final class LogoutUserAction implements LogoutsUserAction
{

    public function run(User $currentUser): void
    {
        if (!$currentAccessToken = $currentUser->currentAccessToken())
        {
            throw ValidationException::withMessages([
                                                        'user' => ['User has no token.'],
                                                    ]);
        }

        $currentAccessToken->delete();
    }
}
