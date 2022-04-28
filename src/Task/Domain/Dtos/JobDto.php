<?php

namespace Freelance\Task\Domain\Dtos;

use Freelance\Task\Domain\Models\Category;
use Freelance\Task\Domain\ValueObjects\Id;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class JobDto
{
    /**
     * @param Id[] $categoryIds
     * @param UploadedFile[] $media
     */
    private function __construct(
        private string $name,
        private string $description,
        private array  $categoryIds,
        private array  $media,
    ) {
    }

    public static function create($name, $description, $category_ids = [], $media = [])
    {
        self::validate(get_defined_vars());
        return new self (
            name       : $name,
            description: $description,
            categoryIds: array_map(fn($id) => Id::create($id), $category_ids),
            media      : $media,
        );
    }

    private static function validate(array $args): void
    {
        Validator::validate(
            $args, [
                     'name'          => ['required', 'string', 'min:2', 'max:255'],
                     'description'   => ['required', 'string', 'min:2', 'max:10000'],
                     'category_ids'   => ['present', 'array'],
                     'category_ids.*' => [
                         'nullable',
                         Rule::exists(Category::class, 'id'),
                     ],
                     'media'         => [
                         'present', 'array'
                     ],
                     'media.*'       => [
                         'nullable',
                         'file'
                     ],
                 ]

        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Id[]
     */
    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    /**
     * @return UploadedFile[]
     */
    public function getMedia(): array
    {
        return $this->media;
    }
}
