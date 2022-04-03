<?php

use Freelance\User\Domain\Actions\Contracts\LoginsUserAction;
use Freelance\User\Domain\Models\User;

uses(\Tests\FeatureTestCase::class);

it('login store method calls proper action and returns token', function () {
    $user = User::factory()->email('test@test.test')->password('12345678')->create();
    $this->postJson(route('login'), [
        'email'    => $user->email->value(),
        'password' => '12345678',
    ])->assertSuccessful()->assertJsonStructure(['token']);
})->shouldHaveCalledAction(LoginsUserAction::class);
