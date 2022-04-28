<?php

namespace Freelance\Task\Application\Http\Resources\Client;

use Freelance\Task\Application\Http\Resources\Admin\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'          => $this->resource->id,
            'name'        => $this->resource->name,
            'description' => $this->resource->parent_id,

            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'media' => MediaResource::collection($this->whenLoaded('media')),

            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
