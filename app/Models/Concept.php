<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    protected $fillable = [
        "deprecated",
        "concept"
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ["terms"];

    public function deprecatedTo() {
        return $this->hasOne("\App\Models\Concept", "foreign_key","deprecated_to");
    }

    public function terms() {
        return $this->hasMany("App\Models\Term");
    }

    public function broader() {
        return $this->belongsToMany("App\Models\Concept", "concept_relationships", "concept_id", "related_concept_id")
                        ->withPivot("relationship_type")
                        ->wherePivot("relationship_type", "broader");
    }

    public function narrower() {
        return $this->belongsToMany("App\Models\Concept", "concept_relationships", "concept_id", "related_concept_id")
                        ->withPivot("relationship_type")
                        ->wherePivot("relationship_type", "narrower");
    }

    //
    //     // coming from other direction
    // public function narrower() {
    //     return $this->belongsToMany("App\Models\Concept", "concept_relationships", "related_concept_id", "concept_id")
    //                     ->withPivot("relationship_type")
    //                     ->wherePivot("relationship_type", "broader");
    // }
    //

    public function related() {
        return $this->belongsToMany("App\Models\Concept", "concept_relationships", "related_concept_id", "concept_id")
                        ->withPivot("relationship_type")
                        ->wherePivot("relationship_type", "related");
    }

    public function addBroader($concept) {
        return $this->broader()->attach([$concept => ["relationship_type" => "broader"]])->save();
    }

    public function addNarrower($concept) {
        // TODO : check it works for new narrower enum
        return $this->narrower()->attach([$concept => ["relationship_type" => "narrower"]])->save();
    }
}
