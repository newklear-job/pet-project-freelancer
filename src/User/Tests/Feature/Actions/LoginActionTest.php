<?php

use Freelance\User\Domain\Actions\Contracts\LoginsUserAction;
use Freelance\User\Domain\Dtos\LoginDto;
use Freelance\User\Domain\Models\User;
use Laravel\Sanctum\NewAccessToken;

uses(\Tests\FeatureTestCase::class);

it('returns token on successful login', function () {
    $user = User::factory()->email('test@test.test')->password('12345678')->create();

    $action = app(LoginsUserAction::class);
    $dto = LoginDto::create(
        $user->email->value(),
        '12345678'
    );
    $token = $action->run($dto);
    expect($token)->toBeInstanceOf(NewAccessToken::class);
});

it('returns validation error when wrong credentials are used on login', function (array $data, array $errors) {
    User::factory()->email('test@test.test')->password('12345678')->create();
    $action = app(LoginsUserAction::class);
    $dto = LoginDto::create(
        ...$data
    );
    expect(fn() => $action->run($dto))->toBeInvalid($errors);
})->with([
             'incorrect credentials'               => [
                 [
                     'test@test.test',
                     'password'
                 ],
                 [
                     'email' => 'Incorrect'
                 ]
             ],
         ]);

