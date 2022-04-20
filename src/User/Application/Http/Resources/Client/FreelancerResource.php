<?php

namespace Freelance\User\Application\Http\Resources\Client;

use Freelance\User\Domain\ValueObjects\Id;
use Freelance\User\Infrastructure\Repositories\FreelancerRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class FreelancerResource extends JsonResource
{

    public function toArray($request)
    {
        $repository = app(FreelancerRepository::class);
        return [
            'user_id'    => $this->resource->user_id,
            'hour_rate'  => $this->resource->hour_rate->formatted(),
            'category_ids' => $repository->getFreelancerCategoriesPivot(
                Id::create($this->resource->id)
            )->pluck('category_id')
        ];
    }
}
