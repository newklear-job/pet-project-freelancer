<?php

namespace Freelance\Task\Application\Policies;

use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\User\Contracts\AuthorizationService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class JobPolicy
{
    use HandlesAuthorization;

    public function __construct(
        private AuthorizationService $authorization
    ) {
    }

    public function index(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function show(User $user, Id $id)
    {
        return true;
    }

    public function update(User $user, Id $id)
    {
        return true;
    }

    public function delete(User $user, Id $id)
    {
        return true;
    }
}
