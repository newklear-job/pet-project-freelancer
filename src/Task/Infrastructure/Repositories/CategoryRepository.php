<?php

namespace Freelance\Task\Infrastructure\Repositories;

use App\ValueObjects\Id;
use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryRepository
{
    public function getPaginatedForAdminPanel(): LengthAwarePaginator;

    public function create(CategoryDto $dto): Category;

    public function update(Id $id, CategoryDto $dto): Category;

    public function getById(Id $id): Category;

    public function deleteById(Id $id): void;
}
