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

        $teacher_concept = Concept::create(["deprecated" => false]);

        $teacher_terms = [
            ["text" => "Teachers", "preferred" => true],
            ["text" => "Educators", "preferred" => false],
            ["text" => "Faculty (Teachers", "preferred" => false],
            ["text" => "Instructors", "preferred" => false],
            ["text" => "Schoolteachers", "preferred" => false],
            ["text" => "School teachers", "preferred" => false]
        ];



        foreach ($teacher_terms as $term) {
            $teacher_concept->terms()->create($term);
        }


$loc_concepts_json = '
    {    "concepts": [
      {
        "id": "dg2015060196",
        "sourceURL": "http://id.loc.gov/authorities/demographicTerms/dg2015060196",
        "conceptType": "occupation",
        "preferredTerm": "Academic librarians",
        "alternativeTerm": [
          "College librarians",
          "Community college librarians",
          "University librarians"
        ],
        "relatedConcept": {
          "relatedConceptType": "broader",
          "relatedConceptTerm": "Librarians",
          "relatedConceptId": "dg2015060192"
        }
      },
      {
        "id": "dg2015060050",
        "sourceURL": "http://id.loc.gov/authorities/demographicTerms/dg2015060050",
        "conceptType": "occupation",
        "preferredTerm": "Accountants",
        "alternativeTerm": [
          "Certified public accountants",
          "Chartered accountants",
          "Public accountants"
        ]
      },
      {
        "id": "dg2015060362",
        "sourceURL": "http://id.loc.gov/authorities/demographicTerms/dg2015060362",
        "conceptType": "ethnicity",
        "preferredTerm": "African Americans",
        "alternativeTerm": [
          "Afro-Americans",
          "Americans, African",
          "Americans, Afro-"
        ],
        "relatedConcept": {
          "relatedConceptType": "related",
          "relatedConceptTerm": "Blacks",
          "relatedConceptId": "dg2015060859"
        }
      },
      {
        "id": "dg2015060275",
        "sourceURL": "http://id.loc.gov/authorities/demographicTerms/dg2015060275",
        "conceptType": "religion",
        "preferredTerm": "African Methodist Episcopal Church members",
        "alternativeTerm": [
          "A.M.E. Church members",
          "AME Church members"
        ],
        "relatedConcept": {
          "relatedConceptType": "broader",
          "relatedConceptTerm": "Methodists",
          "relatedConceptId": "dg2015060384"
        }
    }
    ]
  }
';

$loc_concepts = json_decode($loc_concepts_json, true);

        foreach ($loc_concepts["concepts"] as $concept) {

            $newConcept = Concept::create(["deprecated" => false]);

            // create preferred term
            $preferredTerm = ["text" => $concept["preferredTerm"], "preferred" => true];
            $newConcept->terms()->create($preferredTerm);

            // create alternative terms
            if (isset($concept["alternativeTerm"])) {
                foreach ($concept["alternativeTerm"] as $alternativeTerm) {
                    $newAlternativeTerm = ["text" => $alternativeTerm, "preferred" => false];
                    $newConcept->terms()->create($newAlternativeTerm);
                }
            }

        }

    }
}
