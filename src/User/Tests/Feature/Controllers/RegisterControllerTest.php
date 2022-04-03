<?php

use Freelance\User\Domain\Actions\Contracts\RegistersUserAction;

uses(\Tests\FeatureTestCase::class);

it('register store method calls proper action and returns token', function () {
    $this->postJson(route('register'), [
        'email'                 => 'test@test.test',
        'name'                  => 'name',
        'password'              => '12345678',
        'password_confirmation' => '12345678',
    ])->assertSuccessful()->assertJsonStructure(['token']);
})->shouldHaveCalledAction(RegistersUserAction::class);
