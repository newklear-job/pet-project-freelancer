<?php

namespace Freelance\User\Application\Http\Controllers;

final class UserController
{
    public function show() //todo: update.
    {
        return request()?->user();
    }
}
