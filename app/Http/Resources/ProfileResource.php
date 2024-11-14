<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            "id" => $this->resource->id,
            "first_name" => $this->resource->first_name,
            "last_name" => $this->resource->last_name,
            "image" => new ImageResource($this->resource->getMedia('image')->first()),
            "created_at" => $this->resource->created_at,
        ];

        if(auth('sanctum')->user()) {
            $data = array_merge($data, [
                'status' => $this->resource->status,
            ]);
        }

        return $data;
    }
}
