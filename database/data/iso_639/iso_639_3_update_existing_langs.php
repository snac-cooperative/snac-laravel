<?php

use App\Models\Vocabulary;
use Illuminate\Support\Facades\DB;

// Languages:
// Vocabulary::where('type', 'language_code')->where('value', 'eng')->first();
// Vocabulary::where('type', 'language_code')->count()
// Vocabulary::find($id)

// 506 count

// update iso languages
$count = 0;
$handle = fopen("./database/data/iso_639/iso_639_3_update_existing_langs.csv", "r");

while (($data = fgetcsv($handle, 1000, ',')) !== false) {
  $id = $data[0];
  // $code_2 = $data[1];
  // $description = $data[2];
  $new_code = $data[3];
  $new_desc = $data[4];

  $count++;

  // skip headers
  if ($count == 1)
    continue;

  $lang = Vocabulary::find($id);
  echo "Updating id: $id, to $new_code, $new_desc \n";
  $lang->update(['value' => $new_code, 'description' => $new_desc]);
}
fclose($handle);
