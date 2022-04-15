<?php

namespace Freelance\User\Application\Http\Controllers\Client;

final class UserController
{
    public function show() //todo: update.
    {
        return request()?->user();
    }
}
