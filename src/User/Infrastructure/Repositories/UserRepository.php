<?php

namespace Freelance\User\Infrastructure\Repositories;

use Freelance\User\Domain\Dtos\RegisterDto;
use Freelance\User\Domain\ValueObjects\Email;

interface UserRepository
{
    public function findByEmail(Email $email);

    public function create(RegisterDto $dto);
}
