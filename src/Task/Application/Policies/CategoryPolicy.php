<?php

namespace Freelance\Task\Application\Policies;

use App\ValueObjects\Id;
use Freelance\User\Contracts\AuthorizationService;
use Freelance\User\Domain\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
