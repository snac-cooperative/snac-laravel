<?php

use Illuminate\Database\Seeder;
use App\Models\Concept;
use App\Models\Term;

class ConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json_data = File::get("/home/vagrant/code/snac-laravel/database/data/loc_dgt.json");
        $loc_concepts_json = json_decode($json_data, true);

        foreach ($loc_concepts_json["record"] as $concept) {

            $newConcept = Concept::create(["deprecated" => false]);

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

    }
}

