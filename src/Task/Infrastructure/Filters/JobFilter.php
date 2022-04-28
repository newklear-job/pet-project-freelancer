<?php

namespace Freelance\Task\Infrastructure\Filters;


use Filterable\QueryFilter;

final class JobFilter extends QueryFilter
{
    public function name(string $name): void
    {
        $this->builder->where('name', 'like', "%$name%");
    }

    public function description(string $description): void
    {
        $this->builder->where('description', $description);
    }

    public function categoryIds(array $categoryIds): void
    {
        $this->builder->whereHas('categories', fn($query) => $query->whereIn('categories.id', $categoryIds));
    }
}
