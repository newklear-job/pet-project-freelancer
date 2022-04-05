<?php

namespace Freelance\Task\Application\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'        => $this->resource->id,
            'name'      => $this->resource->name,
            'parent_id' => $this->resource->parent_id,

            'parent'   => $this->whenLoaded('parent'),
            'children' => $this->whenLoaded('children'),

            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
