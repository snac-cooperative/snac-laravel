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

// Insert Concepts and Preferred and Alternative Terms
echo "Inserting Concepts and Preferred and Alternate Terms \n";

$nmai = Vocabulary::where('type', 'concept_category')->where('value', 'National Museum of the American Indian Culture Thesaurus')->first();
$handle = fopen("./database/data/concept_vocab_ingest/nmai_ingest_07_2025.csv", "r");

$count = 0;
while (($data = fgetcsv($handle, 1000, ',')) !== false) {
  $count++;

  // skip headers
  if ($count == 1 || $count == 2)
    continue;

  $sourceUrl =         $data[0];  // Concept Source: Url
  $sourceCitation =    $data[1];  // Concept Source: Citation
  $preferredTerm =     $data[2];
  $scopeNote =         $data[3];
  $altTerms =          $data[4];
  $scopeNoteAddition = $data[5];
  $foundData =         $data[6];  // Concept Source: Found data

  echo "$preferredTerm \n";

  $exists = Term::join('concept_categories', 'terms.concept_id', '=', 'concept_categories.concept_id')
    ->where('concept_categories.category_id', $nmai->id)
    ->where('text', $preferredTerm)->exists();
  if (!$exists) {
    echo "Inserting: $preferredTerm \n";
    $newConcept = Concept::create(["deprecated" => false]);
    $newConcept->terms()->create(["text" => $preferredTerm, "preferred" => true]);
    $newConcept->conceptCategories()->save($nmai);

    if (isset($altTerms) && !empty($altTerms)) {
      $altTerms = array_map('trim', explode(';', $altTerms));
      foreach ($altTerms as $altTerm) {
        if (isset($altTerm)) {
          echo "altTerm: $altTerm \n";
          $newConcept->terms()->create(["text" => $altTerm, "preferred" => false]);
        }
      }
    }
    $note = trim($scopeNote . "\n" . $scopeNoteAddition);
    $newConcept->sources()->create([
      "url" => $sourceUrl,
      "citation" => $sourceCitation,
      "found_data" => $foundData,
      "note" => $note
    ]);
    $newConcept->save();
  }
}

fclose($handle);
