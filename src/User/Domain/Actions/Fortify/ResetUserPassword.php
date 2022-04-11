<?php

namespace Freelance\User\Domain\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Laravel\Fortify\Rules\Password;

class ResetUserPassword implements ResetsUserPasswords
{
    /**
     * Validate and reset the user's forgotten password.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    public function reset($user, array $input)
    {
        Validator::make($input, [
            'password' => ['required', 'string', new Password, 'confirmed'],
        ])->validate();

        $user->forceFill([
                             'password' => Hash::make($input['password']),
                         ])->save();
    }
}
