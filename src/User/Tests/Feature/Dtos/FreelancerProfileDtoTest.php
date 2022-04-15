<?php

use Freelance\User\Domain\Dtos\FreelancerProfileDto;
use Freelance\User\Domain\Models\User;

uses(\Tests\FeatureTestCase::class);

it('returns valid dto on create', function () {
    $user = User::factory()->create();
    $dto = FreelancerProfileDto::create(
        $user->id,
        1000,
    );
    expect($dto)->toBeInstanceOf(FreelancerProfileDto::class);
});

it('handles freelancer profile validation', function (array $data, array $errors) {
    $data = [
        $data['user_id'] ?? 1,
        $data['hour_rate'] ?? 1000,
    ];
    expect(fn() => FreelancerProfileDto::create(
        ...$data
    ))->toBeInvalid($errors);
})->with([
             'user id is not set'         => [
                 [
                     'user_id' => '',
                 ],
                 [
                     'user_id' => 'required'
                 ]
             ],
             'user_id does not exist' => [
                 [
                     'user_id' => 123,
                 ],
                 [
                     'user_id' => 'valid'
                 ]
             ],
             'hour rate is not set'          => [
                 [
                     'hour_rate' => '',
                 ],
                 [
                     'hour_rate' => 'required'
                 ]
             ],
             'hour rate is not numeric'               => [
                 [
                     'hour_rate' => 'abc',
                 ],
                 [
                     'hour_rate' => 'number'
                 ]
             ],
             'hour rate <= 0'        => [
                 [
                     'hour_rate' => 0,
                 ],
                 [
                     'hour_rate' => '0',
                 ]
             ],
         ]);

