<?php

namespace Freelance\Task\Contracts;


interface CategoryService
{
    /**
     * @param int[] $categoryIds
     * @return bool
     */
    public function doesCategoriesExist(array $categoryIds): bool;

}
