<?php

namespace Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfileApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Réponse unauthorized lorsque l'utilisateur n'est pas connecté pour de la modification
     */
    public function test_user_authenticated_for_crud(): void
    {
        $response = $this->postJson('/api/profiles', [
            'first_name' => 'Test',
            'last_name' => 'Profil',
            'status' => 'active',
            'image' => UploadedFile::fake()->image('image.jpg')
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test récupération des profils actifs
     */
    public function test_get_profiles(): void
    {
        Profile::factory()->create(['status' => 'inactive']);
        Profile::factory()->create(['status' => 'waiting']);
        Profile::factory()->create(['status' => 'active']);

        $response = $this->getJson('/api/profiles');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'profiles' => [
                'data' => [],
                'total',
                'per_page',
                'current_page',
                'total_pages',
            ]
        ]);

        $response->assertJsonCount(1, 'profiles.data');
    }

    /**
     * Test retour API lors de la création d'un profil
     */
    public function test_authenticated_admin_can_create_profile()
    {
        /**
         * Création d'un utilisateur
         */
        $admin = User::factory()->create();

        /**
         * Authentification de l'utilisateur
         */
        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/profiles', [
            'first_name' => 'Test',
            'last_name' => 'Profil',
            'status' => 'active',
            'image' => UploadedFile::fake()->image('image.jpg')
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'profile' => [
                'id',
                'first_name',
                'last_name',
                'image' => [
                    'url',
                    'url_sd',
                    'url_md',
                    'url_hd',
                ],
                'created_at',
                'status'
            ]
        ]);
    }

    /**
     * Test retour API lors de la modification d'un profil
     */
    public function test_authenticated_admin_can_update_profile()
    {
        /**
         * Création d'un utilisateur
         */
        $admin = User::factory()->create();

        /**
         * Authentification de l'utilisateur
         */
        $this->actingAs($admin, 'sanctum');

        /** @var Profile $profile */
        $profile = Profile::factory()->create();

        /**
         * Création d'une image fictive
         */
        $image = UploadedFile::fake()->image('image.jpg');

        /**
         * Ajout d'une image au profil
         */
        $profile->addMedia($image)
            ->toMediaCollection('image');

        $response = $this->postJson("/api/profiles/{$profile->id}", [
            'first_name' => 'John',
            'last_name' => 'Dupont',
            'status' => 'active',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'profile' => [
                'id',
                'first_name',
                'last_name',
                'image' => [
                    'url',
                    'url_sd',
                    'url_md',
                    'url_hd',
                ],
                'created_at',
                'status'
            ]
        ]);
    }

    /**
     * Test retour API lors de la suppression d'un profil
     */
    public function test_authenticated_admin_can_delete_profile()
    {
        /**
         * Création d'un utilisateur
         */
        $admin = User::factory()->create();

        /**
         * Authentification de l'utilisateur
         */
        $this->actingAs($admin, 'sanctum');

        /** @var Profile $profile */
        $profile = Profile::factory()->create();

        /**
         * Création d'une image fictive
         */
        $image = UploadedFile::fake()->image('image.jpg');

        /**
         * Ajout d'une image au profil
         */
        $profile->addMedia($image)
            ->toMediaCollection('image');

        $response = $this->deleteJson("/api/profiles/{$profile->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'success'
        ]);
    }
}
