<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptCategory extends Model {

    public function concept() {
        return $this->belongsTo("App\Models\Concept");
    }

    public function vocabulary() {
        return $this->belongsTo("App\Models\Vocabulary");
    }

    // Add ConceptCategories to Vocabulary table
    // INSERT INTO vocabulary (type, value) VALUES
    // ('concept_category', 'Subject'),
    // ('concept_category', 'Activity'),
    // ('concept_category', 'Occupation'),
    // ('concept_category', 'Relation'),
    // ('concept_category', 'Ethnicity'),
    // ('concept_category', 'Religion');

}
