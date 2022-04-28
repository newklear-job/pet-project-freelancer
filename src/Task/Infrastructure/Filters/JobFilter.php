<?php

namespace Freelance\Task\Infrastructure\Filters;


use Filterable\QueryFilter;

final class JobFilter extends QueryFilter
{
    public function name(string $name): void
    {
        $this->builder->where('name', 'like', "%$name%");
    }

    public function parentId($parentId): void
    {
        $this->builder->where('parent_id', $parentId);
    }
}
