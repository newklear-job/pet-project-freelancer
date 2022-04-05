<?php

namespace Freelance\Task\Infrastructure\Repositories;

use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Domain\ValueObjects\Id;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

final class EloquentCategoryRepository implements CategoryRepository
{
    public function getPaginatedForAdminPanel(): LengthAwarePaginator
    {
        return Category::query()
                       ->paginate();
    }

    public function create(CategoryDto $dto): Category
    {
        return Category::create([
                                    'name'      => $dto->getName(),
                                    'parent_id' => $dto->getParentId()?->value()
                                ]);
    }

    public function update(Id $id, CategoryDto $dto): Category
    {
        if ($dto->getParentId() && $id->equals($dto->getParentId())) {
            throw ValidationException::withMessages([
                                                        'parent_id' => ['Cannot set parent_id of himself.'],
                                                    ]);
        }
        $entity = $this->getById($id);
        $entity->name = $dto->getName();
        $entity->parent_id = $dto->getParentId()?->value();
        $entity->save();
        return $entity;
    }

    public function getById(Id $id): Category
    {
        return Category::findOrFail($id->value());
    }

    public function deleteById(Id $id): void
    {
        $entity = $this->getById($id);
        foreach ($entity->children()->get() as $children) {
            $children->parent_id = $entity->parent_id;
            $children->save();
        }
        $entity->delete();
    }
}
