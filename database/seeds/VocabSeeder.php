<?php

use Illuminate\Database\Seeder;
use App\Models\Concept;
use App\Models\ConceptCategory;
use App\Models\ConceptSource;
use App\Models\ConceptProperty;
use App\Models\Term;
use App\Models\Vocabulary;
use App\Models\IdentityConcept;
use Illuminate\Support\Facades\DB;


class VocabSeeder extends Seeder
{
    /**
     * Ingest subject, occupation, and activity terms from 'vocabulary' table and copy 'subject', 'occupation',
     * and 'activity' tables into identity_concepts table. Collapse duplicate terms (e.g. 'Teacher' subject and
     * 'Teacher' occupation) into a single id.
     *
     * Initial terms are taken from a csv of normalized subjects, occupations, and activities from the Vocabulary table.
     *
     *
     * @return void
     */
    public function run() {
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

        // To see original subjects, activities, and occupations in Vocabulary:
        // $subs_acts_occs = Vocabulary::wherein('type', ['subject', 'activity', 'occupation'])->get();


        $count = 0;
        $cache = [];

        $handle = fopen("./database/data/subs_occs_acts_prod_cleaned.csv", "r");

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $vocab_term_id = $data[0];
            $vocab_type = $data[1];
            $cleaned_vocab_term = $data[3];

            $count++;
            echo "#" . $count . ", " . $vocab_term_id . ": " . $cleaned_vocab_term ."\n";
            if ($count == 1)
                continue;             // skip headers

            if (isset($cache[$cleaned_vocab_term])) {
                $concept = $cache[$cleaned_vocab_term];
                $category = $categories[$vocab_type];
                // check/update categories
                if (!$concept->conceptCategories()->find($category)) {
                    $concept->conceptCategories()->save($category);
                }

                // overwrite old vocab ids
                DB::table('identity_concepts')
                    ->where('concept_id',$vocab_term_id)
                    ->update(['concept_id' => $concept->id]);

            } else {
                $concept = Concept::create(['id' => $vocab_term_id, 'deprecated' => false]);
                $preferredTerm = ['text' => $cleaned_vocab_term, 'preferred' => true];
                $concept->terms()->create($preferredTerm);

                // add category
                $category = $categories[$vocab_type];
                $concept->conceptCategories()->save($category);

                $cache[$cleaned_vocab_term] = $concept;
             }
        }
        fclose($handle);
    }
}
