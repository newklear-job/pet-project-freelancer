<?php

use Freelance\Task\Domain\Actions\Contracts\CreatesCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\DeletesCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\GetsPaginatedCategoriesAction;
use Freelance\Task\Domain\Actions\Contracts\ShowsCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\UpdatesCategoryAction;
use Freelance\Task\Domain\Models\Category;

uses(\Tests\FeatureTestCase::class);

it('category index returns data and calls action', function () {
    $this->seed();
    $category = Category::factory()->create();
    loginAsAdmin();
    $this->getJson(route('admin.categories.index'))
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
    $this->seed();
    loginAsAdmin();
    $this->postJson(route('admin.categories.store'), [
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
    $this->seed();
    loginAsAdmin();
    $category = Category::factory()->create();
    $this->getJson(route('admin.categories.show', $category->id))
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
    $this->seed();
    loginAsAdmin();
    $category = Category::factory()->create();
    $parent = Category::factory()->create();
    $this->patchJson(route('admin.categories.update', $category->id), [
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
    $this->seed();
    loginAsAdmin();
    $category = Category::factory()->create();
    $this->deleteJson(route('admin.categories.destroy', $category->id))
         ->assertSuccessful();
})->shouldHaveCalledAction(DeletesCategoryAction::class);

it('category endpoints are closed to regular users', function () {
    login();
    $this->getJson(route('admin.categories.index'))
         ->assertForbidden();
    $this->postJson(route('admin.categories.store'))
         ->assertForbidden();
    $this->getJson(route('admin.categories.show', 1))
         ->assertForbidden();
    $this->patchJson(route('admin.categories.update', 1))
         ->assertForbidden();
    $this->deleteJson(route('admin.categories.destroy', 1))
         ->assertForbidden();
});
