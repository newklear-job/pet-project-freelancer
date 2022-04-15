<?php

namespace Freelance\User\Application\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class FreelancerPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
    }

    public function update(User $user)
    {
        return true;
    }

}
