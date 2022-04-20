<?php

namespace Freelance\User\Infrastructure\Repositories;

use Freelance\Task\Contracts\CategoryService;
use Freelance\User\Domain\Dtos\FreelancerProfileDto;
use Freelance\User\Domain\Models\Freelancer;
use Freelance\User\Domain\ValueObjects\Id;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class EloquentFreelancerRepository implements FreelancerRepository
{
    public function __construct(
        private CategoryService $categoryService,
    ) {
    }

    public function updateOrCreateProfile(FreelancerProfileDto $dto): Freelancer
    {
        return Freelancer::updateOrCreate(
            [
                'user_id' => $dto->getUserId()
            ],
            [
                'hour_rate' => $dto->getHourRate()
            ]
        );
    }

    /**
     * @param Id[] $categoryIds
     */
    public function syncCategories(Id $freelancerId, array $categoryIds): void
    {
        if (!$this->categoryService->doesCategoriesExist($categoryIds)) {
            throw ValidationException::withMessages(['category_ids' => 'Some of the category ids does not exist']);
        }

        $categoryFreelancerPivot = $this->getFreelancerCategoriesPivot($freelancerId);
        $existingCategoryIds = $categoryFreelancerPivot->pluck('category_id');

        $newCategoryIds = collect(array_map(fn($id) => $id->value(), $categoryIds));

        $toDelete = $existingCategoryIds->diff($newCategoryIds);
        $toCreate = $newCategoryIds->diff($existingCategoryIds);

        DB::table('category_freelancer')
          ->where('freelancer_id', $freelancerId->value())
          ->whereIn('category_id', $toDelete->toArray())
          ->delete();

        $insertCollection = $toCreate->map(fn($id) => ['category_id' => $id, 'freelancer_id' => $freelancerId->value()]
        );
        DB::table('category_freelancer')
          ->insert($insertCollection->toArray());
    }

    public function getFreelancerCategoriesPivot(Id $freelancerId): Collection
    {
        return DB::table('category_freelancer')
                 ->where('freelancer_id', $freelancerId->value())
                 ->get();
    }

    public function findById(Id $id): Freelancer
    {
        return Freelancer::where('id', $id->value())->firstOrFail();
    }
}
