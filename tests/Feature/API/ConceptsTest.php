<?php

namespace Tests\Feature\API;

use App\Models\Concept;
use App\Models\Role;
use App\Models\Term;
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
        // Create test concepts with terms
        $concept1 = Concept::factory()->create(['deprecated' => false]);
        $concept2 = Concept::factory()->create(['deprecated' => false]);
        $deprecatedConcept = Concept::factory()->create(['deprecated' => true]);

        // Create terms for the concepts
        $term1 = Term::create([
            'concept_id' => $concept1->id,
            'text' => 'test search term 1',
            'preferred' => true,
        ]);

        $term2 = Term::create([
            'concept_id' => $concept2->id,
            'text' => 'test search term 2',
            'preferred' => false,
        ]);

        $term3 = Term::create([
            'concept_id' => $deprecatedConcept->id,
            'text' => 'test search term deprecated',
            'preferred' => true,
        ]);

        // Test basic search
        $response = $this->getJson('/api/concepts/search?term=test%20search%20term');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data') // Only preferred terms by default
            ->assertJsonPath('data.0.id', $concept1->id);

        // Test search with all_terms=true
        $response = $this->getJson('/api/concepts/search?term=test%20search%20term&all_terms=1');
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data') // Both preferred and non-preferred terms
            ->assertJsonMissing(['id' => $deprecatedConcept->id]); // Deprecated concepts should not appear

        // Test validation
        $response = $this->getJson('/api/concepts/search?term=a');
        $response->assertStatus(422); // Should fail validation for min:2
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
                'term3',
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
            'conceptCategories' => $conceptCategories,
        ]);

        $updatedCategories = Concept::find($concept->id)->conceptCategories->toArray();
        $keysToRemove = ["pivot"];
        $cleanedCategories = array_map(function ($item) use ($keysToRemove) {
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
        $broaderConcept = Concept::factory()->create();
        $narrowerConcept = Concept::factory()->create();
        $relatedConcept = Concept::factory()->create();

        // Test broader relationship
        $response = $this->putJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'broader',
            'related_id' => $broaderConcept->id,
        ]);
        $response->assertStatus(200);
        $this->assertTrue($concept->broader->contains($broaderConcept));

        // Test narrower relationship
        $response = $this->putJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'narrower',
            'related_id' => $narrowerConcept->id,
        ]);
        $response->assertStatus(200);
        $this->assertTrue($concept->narrower->contains($narrowerConcept));

        // Test related relationship
        $response = $this->putJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'related',
            'related_id' => $relatedConcept->id,
        ]);
        $response->assertStatus(200);
        $this->assertTrue($concept->related->contains($relatedConcept));
    }

    public function test_relate_concepts_validates_relation_type(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $relatedConcept = Concept::factory()->create();

        $response = $this->putJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'invalid_type',
            'related_id' => $relatedConcept->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['relation_type']);
    }

    public function test_relate_concepts_validates_related_id(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();

        $response = $this->putJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'broader',
            'related_id' => 99999999999999, // Non-existent ID
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['related_id']);
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
            'related_id' => $relatedConcept->id,
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

    public function test_authorized_user_can_remove_concept_relationships(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        // Create test concepts
        $concept = Concept::factory()->create();
        $broaderConcept = Concept::factory()->create();
        $narrowerConcept = Concept::factory()->create();
        $relatedConcept = Concept::factory()->create();

        // Create relationships first
        $concept->addBroader($broaderConcept->id);
        $concept->addNarrower($narrowerConcept->id);
        $concept->addRelated($relatedConcept->id);

        // Test removing broader relationship
        $response = $this->deleteJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'broader',
            'related_id' => $broaderConcept->id,
        ]);
        $response->assertStatus(200);
        $this->assertFalse($concept->fresh()->broader->contains($broaderConcept));

        // Test removing narrower relationship
        $response = $this->deleteJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'narrower',
            'related_id' => $narrowerConcept->id,
        ]);
        $response->assertStatus(200);
        $this->assertFalse($concept->fresh()->narrower->contains($narrowerConcept));

        // Test removing related relationship
        $response = $this->deleteJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'related',
            'related_id' => $relatedConcept->id,
        ]);
        $response->assertStatus(200);
        $this->assertFalse($concept->fresh()->related->contains($relatedConcept));
    }

    public function test_unauthorized_user_cannot_remove_concept_relationships(): void
    {
        $nonReviewerRole = Role::whereDoesntHave('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($nonReviewerRole)->create();
        Sanctum::actingAs($user);

        // Create test concepts
        $concept = Concept::factory()->create();
        $relatedConcept = Concept::factory()->create();

        // Create a relationship first
        $concept->addRelated($relatedConcept->id);

        // Attempt to remove the relationship
        $response = $this->deleteJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'related',
            'related_id' => $relatedConcept->id,
        ]);

        $response->assertStatus(403);
        $this->assertTrue($concept->fresh()->related->contains($relatedConcept));
    }

    public function test_removing_nonexistent_relationship_returns_success(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $nonRelatedConcept = Concept::factory()->create();

        // Attempt to remove a relationship that doesn't exist
        $response = $this->deleteJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'related',
            'related_id' => $nonRelatedConcept->id,
        ]);

        $response->assertStatus(200);
    }

    public function test_removing_relationship_with_invalid_type_returns_error(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $relatedConcept = Concept::factory()->create();

        // Attempt to remove a relationship with invalid type
        $response = $this->deleteJson("/api/concepts/{$concept->id}/relate_concept", [
            'relation_type' => 'invalid_type',
            'related_id' => $relatedConcept->id,
        ]);

        $response->assertStatus(422);
    }

    public function test_concept_limited_to_one_preferred_term_per_language(): void
    {
        $reviewerRole = Role::whereHas('permissions', function ($query) {
            $query->where('label', 'Edit Vocabulary');
        })->first();
        $user = User::factory()->hasAttached($reviewerRole)->create();
        Sanctum::actingAs($user);

        $term = Term::factory()->create(['preferred' => true]);
        $response = $this->patchJson("/api/terms/{$term->id}", [
            'text' => 'second_preferred_term',
            'preferred' => true,
            'language_id' => 130
        ]);
        $this->assertEquals($response['message'], 'Only one preferred term per language');
        $response->assertStatus(500);
    }
}
