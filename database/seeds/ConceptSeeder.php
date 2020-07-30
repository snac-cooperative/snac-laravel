<?php

use Illuminate\Database\Seeder;
use App\Models\Concept;
use App\Models\ConceptSource;
use App\Models\ConceptProperty;
use App\Models\Term;

class ConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $json_data = File::get("database/data/loc_dgt.json");
        $loc_concepts_json = json_decode($json_data, true);

        foreach ($loc_concepts_json["record"] as $concept) {

            $newConcept = Concept::create(["deprecated" => false]);
            $source = new ConceptSource(["url" => $concept["sourceURL"]]);
            $newConcept->sources()->save($source);

            if (isset($concept["scopeNote"])) {
                $property = new App\Models\ConceptProperty([ "type" => "scopeNote", "value" => $concept["scopeNote"]]);
                $newConcept->conceptProperties()->save($property);
            }

            // create preferred term
            $preferredTerm = ["text" => $concept["preferredTerm"], "preferred" => true];
            $newConcept->terms()->create($preferredTerm);

            // create alternative terms
            if (isset($concept["alternativeTerm"])) {
                $alternativeTerms = $concept["alternativeTerm"];
                if(!is_array($concept["alternativeTerm"])) {
                    $alternativeTerms = [$concept["alternativeTerm"]];
                }
                foreach ($alternativeTerms as $alternativeTerm) {
                    $newAlternativeTerm = ["text" => $alternativeTerm, "preferred" => false];
                    $newConcept->terms()->create($newAlternativeTerm);
                }
            }
        }

        // Add relationships
        foreach ($loc_concepts_json["record"] as $conceptJSON) {
            // Find concept
            $concept = Term::firstWhere("text", $conceptJSON["preferredTerm"])
                            ->concept;
            if (isset($conceptJSON["relatedConcept"])) {
                $relatedConcepts = $conceptJSON["relatedConcept"];
                if(!isset($conceptJSON["relatedConcept"][0])) {
                    $relatedConcepts = [$conceptJSON["relatedConcept"]];
                }

                foreach ($relatedConcepts as $relatedConceptJSON) {
                    // Save relation
                    $relatedConcept = Term::firstWhere("text", $relatedConceptJSON["relatedConceptTerm"])
                                        ->concept;

                    if ($relatedConceptJSON["relatedConceptType"] == "broader") {
                        $concept->addBroader($relatedConcept->id);
                    } else {
                        $concept->addRelated($relatedConcept->id);
                    }

                    // Note: It seems possible to add both "broader" and "related" relations with the following line, but it is less explicit
                    // $concept->broader()->attach([$relatedConcept->id => ["relationship_type" => $relatedConceptJSON["relatedConceptType"]]]);
                }
            }

        }

    }
}
