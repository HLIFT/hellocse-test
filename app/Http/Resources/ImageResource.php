<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'url' => $this->resource->getUrl(),
            'url_sd' => $this->resource->getUrl('sd'),
            'url_md' => $this->resource->getUrl('md'),
            'url_hd' => $this->resource->getUrl('hd'),
        ];
    }
}
