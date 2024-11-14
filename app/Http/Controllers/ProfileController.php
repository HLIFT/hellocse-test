<?php

namespace App\Http\Controllers;

use App\Data\ProfileData;
use App\Http\Requests\GetActiveProfilesRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileCollection;
use App\Http\Resources\ProfileResource;
use App\Repositories\ProfileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProfileController extends Controller
{
    private ProfileRepository $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * Index
     * @param GetActiveProfilesRequest $request
     * @return JsonResponse
     */
    public function index(GetActiveProfilesRequest $request): JsonResponse
    {
        $profiles = $this->profileRepository->getActive(
            perPage: $request->get('per_page'),
            page: $request->get('page'),
        );

        return response()->json([
            'profiles' => new ProfileCollection($profiles),
        ]);
    }

    /**
     * Store
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function store(ProfileRequest $request): JsonResponse
    {
        $profileDTO = ProfileData::fromRequest($request);

        if(!$profileDTO->image) abort(422, "L'image est requise.");

        $profile = $this->profileRepository->store($profileDTO);

        return response()->json([
            'profile' => new ProfileResource($profile),
        ]);
    }

    /**
     * Update
     * @param ProfileRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(ProfileRequest $request, int $id): JsonResponse
    {
        $profile = $this->profileRepository->find($id);

        if(!$profile) abort(404, "Profil introuvable.");

        $profileDTO = ProfileData::fromRequest($request);

        $profile = $this->profileRepository->update($profile, $profileDTO);

        return response()->json([
            'profile' => new ProfileResource($profile),
        ]);
    }

    /**
     * Delete
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function delete(Request $request, int $id): JsonResponse
    {
        $profile = $this->profileRepository->find($id);

        if(!$profile) abort(404, "Profil introuvable.");

        $this->profileRepository->delete($profile);

        // Lorsqu'un profil est supprimé l'image associée est automatiquement supprimée

        return response()->json([
            'success' => true,
        ]);
    }
}
