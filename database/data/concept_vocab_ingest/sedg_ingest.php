<?php

use Illuminate\Contracts\Console\Kernel;
use App\Models\Vocabulary;
use App\Models\Concept;
use App\Models\ConceptSource;
use App\Models\Term;
use Illuminate\Support\Facades\DB;


require __DIR__ . '/../../../vendor/autoload.php';         // Composer autoload
$app = require __DIR__ . '/../../../bootstrap/app.php';    // Laravel bootstrap
$kernel = $app->make(Kernel::class);                       // Boot app
$kernel->bootstrap();

$broaders = [
  'Abolition related CPF',
  'Advertisement related CPF',
  'African American church related CPF',
  'Alternative to freedom status persons',
  'Bookkeeping related CPF',
  'Broader Concept Name',
  'Capture/seizure of person related CPF',
  'Chained person related CPF',
  'Confinement related persons',
  'Convict leasing related CPF',
  'Correspondence related CPF',
  'Creation related CPF',
  'Crime related CPF',
  'Crop production related CPF',
  'Domestic services related CPF',
  'Election related CPF',
  'Enslaved person auction related CPF',
  'Escheat related CPF',
  'Freedmen school related CPF',
  'Freedmen town and settlement related CPF',
  'Freedom seeker related CPF',
  'Funeral related CPF',
  'Hotel/lodging services related CPF',
  'Hunting of enslaved person(s) related CPF',
  'Incarceration related CPF',
  'Insurance related CPF',
  'Lynching related CPF',
  'Maltreatment related CPF',
  'Management related CPF',
  'Manufacturing related CPF',
  'Maternal/maternity related persons',
  'Medical related CPF',
  'Migrant related CPF',
  'Military related CPF',
  'Mortgage related CPF',
  'Nations with enslaver status',
  'Overland transport of enslaved persons related CPF',
  'Persons with subjugated status',
  'Protection document related persons',
  'Provisions related CPF',
  'Redemption of enslaved persons related CPF',
  'Residential related CPF',
  'Ritual practice related CPF',
  'Slave patrol related CPF',
  'Slavery era agriculture related CPF',
  'Slavery era demographic group education related CPF',
  'Slavery era finance related CPF',
  'Slavery era property owners',
  'Slavery era related CPF',
  'Slavery era transportation related CPF',
  'Social group related CPF',
  'Spirituality related CPF',
  'Tithe related CPF',
  'Underground railroad related CPF',
  'Waterway transport of enslaved persons related CPF',
  'Waterway vessel operators',
  'Waterway vessel owners',
  'Waterway vessel user'
];

$sedg = Vocabulary::where('type', 'concept_category')->where('value', 'Slavery Era Demographic Groups (SEDG)')->first();

echo "Inserting inital Broader Concepts \n";
// Insert inital Broader Concepts
foreach ($broaders as $broader) {
  // Check if broader already exists for this concept category
  $exists = Term::join('concept_categories', 'terms.concept_id', '=', 'concept_categories.concept_id')->where('concept_categories.category_id', $sedg->id)->where('text', $broader)->exists();
  if (!$exists) {
    echo "Inserting: $broader \n";

    $newBroaderConcept = Concept::create(["deprecated" => false]);
    $preferredTerm = ["text" => $broader, "preferred" => true];
    $newBroaderConcept->terms()->create($preferredTerm);
    $newBroaderConcept->conceptCategories()->save($sedg);
  }
}

// Insert Concepts and Preferred and Alternative Terms
echo "Inserting Concepts and Preferred and Alternate Terms \n";

$sedg = Vocabulary::where('type', 'concept_category')->where('value', 'Slavery Era Demographic Groups (SEDG)')->first();
$handle = fopen("./database/data/concept_vocab_ingest/sedg_ingest_07_2025.csv", "r");

$count = 0;
while (($data = fgetcsv($handle, 1000, ',')) !== false) {
  $count++;

  // skip headers
  if ($count == 1)
    continue;

  $preferredTerm = $data[0];
  $altTerms = $data[1];
  // $scopeNote = $data[2];
  $broaderTerm = $data[3];

  echo "$preferredTerm \n";

  $exists = Term::join('concept_categories', 'terms.concept_id', '=', 'concept_categories.concept_id')
    ->where('concept_categories.category_id', $sedg->id)
    ->where('text', $preferredTerm)->exists();
  if (!$exists) {
    echo "Inserting: $preferredTerm \n";
    $newConcept = Concept::create(["deprecated" => false]);
    $newConcept->terms()->create(["text" => $preferredTerm, "preferred" => true]);
    $newConcept->conceptCategories()->save($sedg);

    if (isset($altTerms)) {
      $altTerms = array_map('trim', explode(';', $altTerms));
      foreach ($altTerms as $altTerm) {
        if (isset($altTerm)) {
          echo "altTerm: $altTerm \n";
          $newConcept->terms()->create(["text" => $altTerm, "preferred" => false]);
        }
      }
    }

    if (isset($broaderTerm) && !empty($broaderTerm)) {
      echo "relating: $broaderTerm \n";
      $broaderConceptId = Term::join('concept_categories', 'terms.concept_id', '=', 'concept_categories.concept_id')
        ->where('concept_categories.category_id', $sedg->id)
        ->where('text', $broaderTerm)
        ->first()
        ->concept_id;
      if (isset($broaderConceptId) && !empty($broaderConceptId)) {
        $newConcept->addBroader($broaderConceptId);
      }
    }
    $newConcept->save();
  }
}

fclose($handle);
