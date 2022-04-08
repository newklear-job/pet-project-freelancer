<?php

use App\ValueObjects\Id;
use Freelance\Task\Domain\Actions\Contracts\DeletesCategoryAction;
use Freelance\Task\Domain\Models\Category;

uses(\Tests\FeatureTestCase::class);

it('deletes category on action call', function () {
    $action = app(DeletesCategoryAction::class);
    $old = Category::factory()->create();
    $action->run(Id::create($old->id));

    $this->assertDatabaseMissing(Category::class, ['id' => $old->id]);
});

it('sets parent_id of all children to deleted category parent_id on action call', function () {
    $action = app(DeletesCategoryAction::class);
    $parent = Category::factory()->create();
    $deleting = Category::factory()->childOf($parent)->create();
    $childOne = Category::factory()->childOf($deleting)->create();
    $childTwo = Category::factory()->childOf($deleting)->create();

    $action->run(Id::create($deleting->id));

    $childOne->refresh();
    $childTwo->refresh();
    $this->assertEquals($parent->id, $childOne->parent_id);
    $this->assertEquals($parent->id, $childTwo->parent_id);
});
