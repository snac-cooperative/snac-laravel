<?php

namespace Tests\Feature\API;

use App\Models\Concept;
use App\Models\Role;
use App\Models\User;
use App\Models\Vocabulary;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ConceptsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_any_can_list_concepts(): void
    {
        $response = $this->getJson('/api/concepts');
        $response->assertStatus(200);
    }

    public function test_any_can_search_concepts(): void
    {
        $response = $this->getJson('/api/concepts?search=example');
        $response->assertStatus(200);
    }

    public function test_any_can_get_concept(): void
    {
        $concept = Concept::first();
        $response = $this->getJson("/api/concepts/{$concept->id}");
        $response->assertStatus(200);
    }

    public function test_any_can_reconcile_concept(): void
    {
        $response = $this->getJson("api/concepts/reconcile?term=teacher&category=occupation");
        $response->assertStatus(200);
    }

    public function test_authorized_user_can_create_concept(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $categoryIds = Vocabulary::where('type', 'concept_category')->pluck('id')->toArray();

        $response = $this->postJson('/api/concepts', [
            'preferred_term' => 'preferred',
            'category_id' => Arr::random($categoryIds),
            'alternate_terms' => [
                'term1',
                'term2',
                'term3'
            ],
        ]);

        $response->assertStatus(201);
    }

    public function test_authorized_user_can_update_concept(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $conceptCategories = Vocabulary::where('type', 'concept_category')->get()->random(2)->toArray();
        $response = $this->patchJson("/api/concepts/{$concept->id}", [
            'conceptCategories' => $conceptCategories
        ]);

        $updatedCategories = Concept::find($concept->id)->conceptCategories->toArray();
        $keysToRemove = ["pivot"];
        $cleanedCategories = array_map(function($item) use ($keysToRemove) {
            return array_diff_key($item, array_flip($keysToRemove));
        }, $updatedCategories);
        $this->assertEqualsCanonicalizing($conceptCategories, $cleanedCategories);

        $response->assertStatus(200);
    }

    public function test_authorized_user_can_update_concept_relationships(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $relatedConcept = Concept::factory()->create();
        $response = $this->putJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'broader',
            'related_id' => $relatedConcept,
        ]);

        $response->assertStatus(200);
    }

    public function test_authorized_user_can_deprecate_concept(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->putJson("/api/concepts/{$concept->id}/deprecate");

        $response->assertStatus(200);
    }

    public function test_authorized_user_can_delete_concept(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->deleteJson("/api/concepts/{$concept->id}");

        $response->assertStatus(204);
    }

    public function test_unauthorized_user_cannot_create_concept(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/concepts', [
            'category_id' => 1,
            'terms' => [['text' => 'New Term']],
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_update_concept(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->putJson("/api/concepts/{$concept->id}", [
            'terms' => [['text' => 'Updated Term']],
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_update_concept_relationships(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $relatedConcept = Concept::factory()->create();
        $response = $this->putJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'broader',
            'related_id' => $relatedConcept,
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_deprecate_concept(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->putJson("/api/concepts/{$concept->id}/deprecate");

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_delete_concept(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->deleteJson("/api/concepts/{$concept->id}");

        $response->assertStatus(403);
    }
}
