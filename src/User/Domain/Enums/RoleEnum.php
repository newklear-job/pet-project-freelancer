<?php

namespace Freelance\User\Domain\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'Super admin';
    case CLIENT = 'Client';
    case FREELANCER = 'Freelancer';
}
