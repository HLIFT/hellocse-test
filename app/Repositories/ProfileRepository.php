<?php

namespace App\Repositories;

use App\Data\ProfileData;
use App\Enums\ProfileStatus;
use App\Models\Profile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProfileRepository
{
    /**
     * Récupération d'un profil par son id
     * @param int $id
     * @return Profile|null
     */
    public function find(int $id): ?Profile
    {
        return Profile::find($id);
    }

    /**
     * Récupération de tous les profils actifs paginés
     * @param int|null $perPage
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function getActive(?int $perPage = null, ?int $page = null): LengthAwarePaginator
    {
        $perPage = $perPage ?? 10;
        $page = $page ?? 1;

        return Profile::query()
            ->where('status', ProfileStatus::Active)
            ->paginate(perPage: $perPage, page: $page);
    }

    /**
     * Création d'un profil
     * @param ProfileData $profileDTO
     * @return Profile
     */
    public function store(ProfileData $profileDTO): Profile
    {
        $profile = Profile::create([
            "first_name" => $profileDTO->firstName,
            "last_name" => $profileDTO->lastName,
            "status" => $profileDTO->status,
        ]);

        $profile->addMedia($profileDTO->image->getRealPath())
            ->toMediaCollection('image');

        return $profile;
    }


    /**
     * Mise à jour d'un profil
     * @param Profile $profile
     * @param ProfileData $profileDTO
     * @return Profile
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(Profile $profile, ProfileData $profileDTO): Profile
    {
        $profile->update([
            "first_name" => $profileDTO->firstName,
            "last_name" => $profileDTO->lastName,
            "status" => $profileDTO->status,
        ]);

        if($profileDTO->image) {
            $profile->addMedia($profileDTO->image->getRealPath())
                ->toMediaCollection('image');
        }

        return $profile;
    }

    /**
     * Suppression d'un profil
     * @param Profile $profile
     * @return void
     */
    public function delete(Profile $profile): void
    {
        $profile->delete();
    }
}
