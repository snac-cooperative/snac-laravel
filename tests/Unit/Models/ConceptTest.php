<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Concept;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Term;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ConceptTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function test_concept_can_have_broader_relationships()
    {
        $concept = Concept::factory()->create();
        $broaderConcept = Concept::factory()->create();

        $concept->addBroader($broaderConcept->id);

        $this->assertTrue($concept->broader->contains($broaderConcept));
        $this->assertTrue($broaderConcept->narrower->contains($concept));
    }

    public function test_concept_can_have_narrower_relationships()
    {
        $concept = Concept::factory()->create();
        $narrowerConcept = Concept::factory()->create();

        $concept->addNarrower($narrowerConcept->id);

        $this->assertTrue($concept->narrower->contains($narrowerConcept));
        $this->assertTrue($narrowerConcept->broader->contains($concept));
    }

    public function test_concept_can_have_related_relationships()
    {
        $concept = Concept::factory()->create();
        $relatedConcept = Concept::factory()->create();

        $concept->addRelated($relatedConcept->id);

        $this->assertTrue($concept->related->contains($relatedConcept));
        $this->assertTrue($relatedConcept->related->contains($concept));
    }
}
