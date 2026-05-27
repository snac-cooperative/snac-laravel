<?php

namespace Tests\Feature\API;

use App\Models\Concept;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ConceptSource;
use App\Models\Role;
use App\Models\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ConceptSourcesTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function test_any_can_list_concept_sources(): void
    {
        $response = $this->getJson('/api/concept_sources');
        $response->assertStatus(200);
    }

    public function test_any_can_get_concept_source(): void
    {
        $conceptSource = ConceptSource::factory()->create();
        $response = $this->getJson("/api/concept_sources/{$conceptSource->id}");
        $response->assertStatus(200);
    }

    public function test_authorized_user_can_create_concept_source(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->postJson('/api/concept_sources', [
            'citation' => $this->faker->sentence(),
            'concept_id' => $concept->id,
            'found_data' => $this->faker->sentence(),
            'note' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
        ]);

        $response->assertStatus(201);
    }

    public function test_authorized_user_can_update_concept_source(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $conceptSource = ConceptSource::factory()->create();
        $response = $this->patchJson("/api/concept_sources/{$conceptSource->id}", [
            'citation' => $this->faker->sentence(),
            'found_data' => $this->faker->sentence(),
            'note' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
        ]);

        $response->assertStatus(200);
    }

    public function test_authorized_user_can_delete_concept_source(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $conceptSource = ConceptSource::factory()->create();
        $response = $this->deleteJson("/api/concept_sources/{$conceptSource->id}");

        $response->assertStatus(204);
    }

    public function test_unauthorized_user_cannot_create_concept_source(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->postJson('/api/concept_sources', [
            'citation' => $this->faker->sentence(),
            'concept_id' => $concept->id,
            'found_data' => $this->faker->sentence(),
            'note' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_update_concept_source(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $conceptSource = ConceptSource::factory()->create();
        $response = $this->patchJson("/api/concept_sources/{$conceptSource->id}", [
            'citation' => $this->faker->sentence(),
            'found_data' => $this->faker->sentence(),
            'note' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_delete_concept_source(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $conceptSource = ConceptSource::factory()->create();
        $response = $this->deleteJson("/api/concept_sources/{$conceptSource->id}");

        $response->assertStatus(403);
    }
}
