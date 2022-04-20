<?php

namespace Freelance\Task\Infrastructure\Services;

use Freelance\Task\Contracts\CategoryService as CategoryServiceContract;
use Freelance\Task\Domain\Models\Category;

final class CategoryService implements CategoryServiceContract
{

    public function doesCategoriesExist(array $categoryIds): bool
    {
        return Category::whereIn('id', $categoryIds)->count() === count($categoryIds);
    }
}
