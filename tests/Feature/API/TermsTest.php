<?php

namespace Tests\Feature\API;

use App\Models\Concept;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Term;
use App\Models\Role;
use App\Models\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class TermsTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function test_any_can_list_terms(): void
    {
        $response = $this->getJson('/api/terms');
        $response->assertStatus(200);
    }

    public function test_any_can_get_term(): void
    {
        $term = Term::first();
        $response = $this->getJson("/api/terms/{$term->id}");
        $response->assertStatus(200);
    }

    public function test_authorized_user_can_create_term(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->postJson('/api/terms', [
            'concept_id' => $concept->id,
            'preferred' => false,
            'text' => $this->faker->word,
        ]);

        $response->assertStatus(201);
    }

    public function test_authorized_user_can_update_term(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $term = Term::factory()->create();
        $response = $this->patchJson("/api/terms/{$term->id}", [
            'text' => $this->faker->word
        ]);

        $this->assertNotEquals(Term::find($term->id)->text, $term->text);
        $response->assertStatus(200);
    }

    public function test_authorized_user_can_delete_term(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $term = Term::factory()->create();
        $response = $this->deleteJson("/api/terms/{$term->id}");

        $response->assertStatus(204);
    }

    public function test_unauthorized_user_cannot_create_term(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->postJson('/api/terms', [
            'concept_id' => $concept->id,
            'preferred' => false,
            'text' => $this->faker->word,
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_update_term(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $term = Term::factory()->create();
        $response = $this->patchJson("/api/terms/{$term->id}", [
            'text' => $this->faker->word
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_delete_term(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $term = Term::factory()->create();
        $response = $this->deleteJson("/api/terms/{$term->id}");

        $response->assertStatus(403);
    }
}
