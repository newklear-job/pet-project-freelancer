<?php

namespace Freelance\User\Application\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class FreelancerResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'user_id' => $this->resource->user_id,
            'hour_rate' => $this->resource->hour_rate->formatted(),
        ];
    }
}
