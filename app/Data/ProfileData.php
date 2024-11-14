<?php

namespace App\Data;

use App\Enums\ProfileStatus;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class ProfileData extends Data
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public ProfileStatus $status,
        public ?UploadedFile $image = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            firstName: $request->get('first_name'),
            lastName: $request->get('last_name'),
            status: ProfileStatus::from($request->get('status')),
            image: $request->file('image'),
        );
    }
}
