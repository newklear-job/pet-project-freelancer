<?php

use Freelance\User\Domain\Dtos\RegisterDto;
use Freelance\User\Domain\Models\User;

uses(\Tests\FeatureTestCase::class);

it('returns valid dto on create', function () {
    $dto = RegisterDto::create(
        'test@test.test',
        'test',
        '12345678',
        '12345678',
    );
    expect($dto)->toBeInstanceOf(RegisterDto::class);
});

it('handles register validation', function (array $data, array $errors) {
    User::factory()->email('unique@test.test')->create();
    $data = [
        $data['email'] ?? 'email',
        $data['name'] ?? 'name',
        $data['password'] ?? 'password',
        $data['password_confirmation'] ?? 'password_confirmation',
    ];
    expect(fn() => RegisterDto::create(
        ...$data
    ))->toBeInvalid($errors);
})->with([
             'email is not set'         => [
                 [
                     'email' => '',
                 ],
                 [
                     'email' => 'required'
                 ]
             ],
             'email is not valid email' => [
                 [
                     'email' => 'email',
                 ],
                 [
                     'email' => 'valid'
                 ]
             ],
             'email > 255'              => [
                 [
                     'email' => str_repeat('a', 256) . "@email.email",
                 ],
                 [
                     'email' => '255'
                 ]
             ],
             'email taken'              => [
                 [
                     'email' => 'unique@test.test',
                 ],
                 [
                     'email' => 'taken'
                 ]
             ],
             'name is not set'          => [
                 [
                     'name' => '',
                 ],
                 [
                     'name' => 'required'
                 ]
             ],
             'name > 255'               => [
                 [
                     'name' => str_repeat('a', 256),
                 ],
                 [
                     'name' => '255'
                 ]
             ],
             'password required'    => [
                 [
                     'password' => '',
                 ],
                 [
                     'password' => 'required',
                 ]
             ],
             'password confirmation'    => [
                 [
                     'password' => 'password',
                     'different_password' => 'different_password',
                 ],
                 [
                     'password' => 'confirmation',
                 ]
             ],
         ]);

