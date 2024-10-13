<?php

namespace Tests\Feature\API;

use App\Models\Concept;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ConceptsTest extends TestCase
{
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
        $concept = Concept::factory()->create();
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
        $user = User::factory()->create(['role' => 'editor']);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/concepts', [
            'category_id' => 1,
            'terms' => [['text' => 'New Term']],
        ]);

        $response->assertStatus(201);
    }

    public function test_authorized_user_can_update_concept(): void
    {
        $user = User::factory()->create(['role' => 'editor']);
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->putJson("/api/concepts/{$concept->id}", [
            'terms' => [['text' => 'Updated Term']],
        ]);

        $response->assertStatus(200);
    }

    public function test_authorized_user_can_update_concept_relationships(): void
    {
        $user = User::factory()->create(['role' => 'editor']);
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->putJson("/api/concepts/{$concept->id}/relationships", [
            'related' => [2, 3],
        ]);

        $response->assertStatus(200);
    }

    public function test_authorized_user_can_deprecate_concept(): void
    {
        $user = User::factory()->create(['role' => 'editor']);
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->patchJson("/api/concepts/{$concept->id}/deprecate");

        $response->assertStatus(200);
    }

    public function test_authorized_user_can_delete_concept(): void
    {
        $user = User::factory()->create(['role' => 'editor']);
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->deleteJson("/api/concepts/{$concept->id}");

        $response->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_create_concept(): void
    {
        $user = User::factory()->create(['role' => 'viewer']);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/concepts', [
            'category_id' => 1,
            'terms' => [['text' => 'New Term']],
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_update_concept(): void
    {
        $user = User::factory()->create(['role' => 'viewer']);
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->putJson("/api/concepts/{$concept->id}", [
            'terms' => [['text' => 'Updated Term']],
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_update_concept_relationships(): void
    {
        $user = User::factory()->create(['role' => 'viewer']);
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->putJson("/api/concepts/{$concept->id}/relationships", [
            'related' => [2, 3],
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_deprecate_concept(): void
    {
        $user = User::factory()->create(['role' => 'viewer']);
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->patchJson("/api/concepts/{$concept->id}/deprecate");

        $response->assertStatus(403);
    }

    public function test_unauthorized_user_cannot_delete_concept(): void
    {
        $user = User::factory()->create(['role' => 'viewer']);
        Sanctum::actingAs($user);

        $concept = Concept::factory()->create();
        $response = $this->deleteJson("/api/concepts/{$concept->id}");

        $response->assertStatus(403);
    }
}
