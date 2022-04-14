<?php

namespace Freelance\Task\Application\Policies;

use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\User\Contracts\AuthorizationService;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function __construct(
        private AuthorizationService $authorization
    ) {
    }

    public function index(User $user)
    {
        return $this->authorization->userHasPermission(Id::create($user->id), '') ? true : null;
    }

    public function create(User $user)
    {
        return $this->authorization->userHasPermission(Id::create($user->id), '') ? true : null;
    }

    public function show(User $user, Id $id)
    {
        return $this->authorization->userHasPermission(Id::create($user->id), '') ? true : null;
    }

    public function update(User $user, Id $id)
    {
        return $this->authorization->userHasPermission(Id::create($user->id), '') ? true : null;
    }

    public function delete(User $user, Id $id)
    {
        return $this->authorization->userHasPermission(Id::create($user->id), '') ? true : null;
    }
}
