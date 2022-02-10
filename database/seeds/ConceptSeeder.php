<?php

use Illuminate\Database\Seeder;
use App\Models\Concept;
use App\Models\ConceptSource;
use App\Models\ConceptProperty;
use App\Models\Term;
use App\Models\Vocabulary;

class ConceptSeeder extends Seeder
{
    /**
     * Ingest concept terms from the Library of Congress demographic group terms and
     * create relationships between them
     *
     *
     * @return void
     */
    public function run() {
        $json_data = File::get("database/data/loc_dgt.json");
        $loc_concepts_json = json_decode($json_data, true);

        // Load ConceptCategories
        $religion = Vocabulary::where('type', 'concept_category')->where('value', 'Religion')->first();
        $ethnicity = Vocabulary::where('type', 'concept_category')->where('value', 'Ethnicity')->first();
        $relation = Vocabulary::where('type', 'concept_category')->where('value', 'Relation')->first();
        $occupation = Vocabulary::where('type', 'concept_category')->where('value', 'Occupation')->first();
        $activity = Vocabulary::where('type', 'concept_category')->where('value', 'Activity')->first();
        $subject = Vocabulary::where('type', 'concept_category')->where('value', 'Subject')->first();

        $categories = [
            'religion' => $religion,
            'ethnicity' => $ethnicity,
            'relation' => $relation,
            'occupation' => $occupation,
            'activity' => $activity,
            'subject' => $subject
        ];


        foreach ($loc_concepts_json["record"] as $concept) {
            $term = Term::where('text', $concept["preferredTerm"])->first();

            if ($term) {
                $LOCConcept = $term->concept;
            } else {
                // create concept and preferred term
                $LOCConcept = Concept::create(["deprecated" => false]);
                $preferredTerm = ["text" => $concept["preferredTerm"], "preferred" => true];
                $LOCConcept->terms()->create($preferredTerm);
            }

            $source = new ConceptSource(["url" => $concept["sourceURL"]]);
            $LOCConcept->sources()->save($source);

            if (isset($concept["scopeNote"])) {
                $property = new App\Models\ConceptProperty([ "type" => "scopeNote", "value" => $concept["scopeNote"]]);
                $LOCConcept->conceptProperties()->save($property);
            }

            // add category
            $conceptTypes = $concept["conceptType"];
            if(!is_array($concept["conceptType"])) {
                $conceptTypes = [$concept["conceptType"]];
            }
            foreach ($conceptTypes as $conceptType) {
                if (!$LOCConcept->conceptCategories()->find($categories[$conceptType])) {
                    $LOCConcept->conceptCategories()->save($categories[$conceptType]);
                }
            }

            // create alternative terms
            if (isset($concept["alternativeTerm"])) {
                $alternativeTerms = $concept["alternativeTerm"];
                if(!is_array($concept["alternativeTerm"])) {
                    $alternativeTerms = [$concept["alternativeTerm"]];
                }
                foreach ($alternativeTerms as $alternativeTerm) {
                    $newAlternativeTerm = ["text" => $alternativeTerm, "preferred" => false];
                    $LOCConcept->terms()->create($newAlternativeTerm);
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
