<?php

use Freelance\User\Domain\Actions\Contracts\RegistersUserAction;
use Freelance\User\Domain\Dtos\RegisterDto;
use Freelance\User\Domain\Models\User;

uses(\Tests\FeatureTestCase::class);

it('returns user on successful register', function () {
    $action = app(RegistersUserAction::class);
    $dto = RegisterDto::create(
        'test@test.test',
        'name',
        '12345678',
        '12345678',

    );
    $user = $action->run($dto);

    expect($user)->toBeInstanceOf(User::class)
        ->email->value()->toBe('test@test.test')
        ->name->toBe('name');
});


