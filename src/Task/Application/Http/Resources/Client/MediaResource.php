<?php

namespace Freelance\Task\Application\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                => $this->resource->id,
            'name'              => $this->resource->name,
            'fileName'          => $this->resource->file_name,
            'order_column'      => $this->resource->order_column,
            'mime_type'         => $this->resource->mime_type,
            'custom_properties' => $this->resource->custom_properties,

            'publicFullUrl' => $this->resource->getFullUrl(),

            'humanReadableSize' => $this->resource->human_readable_size
        ];
    }
}
