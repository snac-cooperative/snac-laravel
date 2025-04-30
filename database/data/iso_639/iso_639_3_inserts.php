<?php

use App\Models\Vocabulary;
use Illuminate\Support\Facades\DB;


// insert new iso languages
$count = 0;
$handle = fopen("./database/data/iso_639/iso_639_3_inserts.csv", "r");

while (($data = fgetcsv($handle, 1000, ',')) !== false) {
  $code_3 = $data[0];
  $description_3 = $data[1];

  $count++;

  // skip headers
  if ($count == 1)
    continue;

  $exists = Vocabulary::where('type', 'language_code')->where('value', $code_3)->exists();
  if (!$exists) {
    echo "Inserting: $count, $code_3, $description_3 \n";
    Vocabulary::create(['type' => 'language_code', 'value' => $code_3, 'description' => $description_3]);
  }
}
fclose($handle);
