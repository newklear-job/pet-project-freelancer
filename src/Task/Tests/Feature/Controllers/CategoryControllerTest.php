<?php

use Freelance\Task\Domain\Actions\Contracts\CreatesCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\DeletesCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\GetsPaginatedCategoriesAction;
use Freelance\Task\Domain\Actions\Contracts\ShowsCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\UpdatesCategoryAction;
use Freelance\Task\Domain\Models\Category;

uses(\Tests\FeatureTestCase::class);

it('category index returns data and calls action', function () {
    $category = Category::factory()->create();
    login();
    $this->getJson(route('categories.index'))
         ->assertSuccessful()
         ->assertJsonStructure([
                                   'data' => [
                                       [
                                           'id',
                                           'name',
                                       ]
                                   ]
                               ])
         ->assertJsonCount(1, 'data')
         ->assertJsonFragment(['name' => $category->name]);
})->shouldHaveCalledAction(GetsPaginatedCategoriesAction::class);

it('category store returns data and calls proper action', function () {
    login();
    $this->postJson(route('categories.store'), [
        'name'      => 'test name',
        'parent_id' => null,
    ])
         ->assertSuccessful()
         ->assertJsonStructure([
                                   'data' => [
                                       'id',
                                       'name',
                                   ]
                               ])
         ->assertJsonFragment(['name' => 'test name']);
})->shouldHaveCalledAction(CreatesCategoryAction::class);

it('category show returns data and calls proper action', function () {
    login();
    $category = Category::factory()->create();
    $this->getJson(route('categories.show', $category->id))
         ->assertSuccessful()
         ->assertJsonStructure([
                                   'data' => [
                                       'id',
                                       'name',
                                   ]
                               ])
         ->assertJsonFragment(['name' => $category->name]);
})->shouldHaveCalledAction(ShowsCategoryAction::class);

it('category update returns data and calls proper action', function () {
    login();
    $category = Category::factory()->create();
    $parent = Category::factory()->create();
    $this->patchJson(route('categories.update', $category->id), [
        'name'      => 'test name',
        'parent_id' => $parent->id
    ])
         ->assertSuccessful()
         ->assertJsonStructure([
                                   'data' => [
                                       'id',
                                       'name',
                                   ]
                               ])
         ->assertJsonFragment(['name' => 'test name']);
})->shouldHaveCalledAction(UpdatesCategoryAction::class);

it('category destroy calls proper action', function () {
    login();
    $category = Category::factory()->create();
    $this->deleteJson(route('categories.destroy', $category->id))
         ->assertSuccessful();
})->shouldHaveCalledAction(DeletesCategoryAction::class);
