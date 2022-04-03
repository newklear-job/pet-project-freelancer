<?php

use Freelance\User\Domain\Dtos\LoginDto;
use Freelance\User\Domain\Models\User;

uses(\Tests\FeatureTestCase::class);

it('returns valid dto on create', function () {
    $user = User::factory()->email('test@test.test')->password('12345678')->create();

    $dto = LoginDto::create(
        $user->email->value(),
        '12345678'
    );
    expect($dto)->toBeInstanceOf(LoginDto::class);
});

it('returns errors when wrong credentials are used on login', function (array $data, array $errors) {

    $data = [
        $data['email'] ?? 'email@email.email',
        $data['password'] ?? 'password',
    ];
    expect(fn() => LoginDto::create(
        ...$data
    ))->toBeInvalid($errors);
})->with([
             'email is not set'                    => [
                 [
                     'email' => ''
                 ],
                 [
                     'email' => 'required'
                 ]
             ],
             'password is not set'                 => [
                 [
                     'password' => '',
                 ],
                 [
                     'password' => 'required'
                 ]
             ],
             'email is not valid'                  => [
                 [
                     'email' => 'not-valid-email',
                 ],
                 [
                     'email' => 'valid'
                 ]
             ],
             'user with such email does not exist' => [
                 [
                     'email' => 'does-not-exist@email.com',
                 ],
                 [
                     'email' => 'invalid'
                 ]
             ],
         ]);

