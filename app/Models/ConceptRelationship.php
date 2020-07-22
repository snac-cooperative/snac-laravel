<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptRelationship extends Pivot
{
    protected $fillable = [
        "deprecated",
    ];

//     public function broader_concept() {
//         // return $this->hasMany("App\Models\ConceptRelationship", "id", "related_concept_id");
//         // $this->belongsTo(self::class, 'parent_id');
//
//         return $this->belongsTo("App\Models\Concept", "concept_id");
//         // return $this->belongsTo("App\Models\ConceptRelationship", "concept_id");
//     }
//
//
//     public function narrower_concept() {
//
//         return $this->hasManyThrough('App\Models\ConceptRelationship', 'App\Models\ConceptRelationshipRelations');
//     }
//
//     public function related_concept() {
//         return $this->belongsTo('concept', 'concept_id');
//     }
//
//     public function concept() {
//         // return $this->hasMany("App\Models\ConceptRelationship", "id", "related_concept_id");
//         // $this->belongsTo(self::class, 'parent_id');
//
//         // return $this->belongsTo("App\Models\ConceptRelationship", "concept_id");
//         return $this->belongsTo("App\Models\Concept");
//     }
// }


// In addition to customizing the name of the joining table, you may also customize the column name
// of the keys on the table by passing additional arguments to the belongsToMany method.
// The third argument is the foreign key name of the model on which you are defining
// the relationship, while the fourth argument is the foreign key name of the model
// that you are joining to:
