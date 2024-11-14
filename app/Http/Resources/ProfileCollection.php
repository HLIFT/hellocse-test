<?php

namespace App\Http\Resources;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProfileCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "data" => $this->collection,
            "total" => $this->total(),
            "per_page" => $this->perPage(),
            "current_page" => $this->currentPage(),
            "total_pages" => ceil($this->total() / $this->perPage())
        ];
    }
}
