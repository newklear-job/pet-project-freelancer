<?php

namespace Freelance\Task\Domain\Dtos;

use Freelance\Task\Domain\ValueObjects\Id;
use Freelance\Task\Domain\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class CategoryDto
{
    private function __construct(
        private string $name,
        private ?Id    $parentId,
    ) {
    }

    public static function create($name, $parent_id)
    {
        self::validate(get_defined_vars());
        return new self (
            name    : $name,
            parentId: $parent_id ? Id::create($parent_id) : $parent_id,
        );
    }

    private static function validate(array $args): void
    {
        Validator::validate(
            $args, [
                     'name'      => ['required', 'string', 'max:255'],
                     'parent_id' => [
                         'nullable',
                         'numeric',
                         Rule::exists(Category::class, 'id'),
                     ],
                 ]

        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParentId(): ?Id
    {
        return $this->parentId;
    }
}
