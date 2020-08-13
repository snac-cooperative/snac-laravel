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

    public function replacementOf() {
        return $this->hasOne("\App\Models\Concept", "deprecated_to");
    }

    public function deprecatedTo() {
        return $this->belongsTo("\App\Models\Concept", "deprecated_to");
    }

    public function setDeprecatedTo($concept) {
        $this->deprecated = true;
        return $this->deprecatedTo()->associate($concept)
            ->save();
    }

    public function terms() {
        return $this->hasMany("App\Models\Term");
    }

    public function broader() {
        return $this->belongsToMany("App\Models\Concept", "concept_relationships", "concept_id", "related_concept_id")
                        ->withPivot("relationship_type")
                        ->wherePivot("relationship_type", "broader");
    }

    // This version requires insert of the two relationships (both ways, narrower and broader)
    //public function narrower() {
        //return $this->belongsToMany("App\Models\Concept", "concept_relationships", "concept_id", "related_concept_id")
                        //->withPivot("relationship_type")
                        //->wherePivot("relationship_type", "narrower");
    //}


    // This version requires insert only one relationships, the other relationship is inferred from concept_id or related_concept_id
    // coming from other direction
     public function narrower() {
         return $this->belongsToMany("App\Models\Concept", "concept_relationships", "related_concept_id", "concept_id")
                         ->withPivot("relationship_type")
                         ->wherePivot("relationship_type", "broader");
     }


    public function related() {
        return $this->belongsToMany("App\Models\Concept", "concept_relationships", "related_concept_id", "concept_id")
                        ->withPivot("relationship_type")
                        ->wherePivot("relationship_type", "related");
    }

    public function addBroader($conceptId) {
        return $this->broader()->attach([$conceptId => ["relationship_type" => "broader"]]);
    }


    public function addRelated($conceptId) {
        return $this->related()->attach([$conceptId => ["relationship_type" => "related"]]);
    }

    // This version requires insert of the two relationships (both ways, narrower and broader)
    // public function addNarrower($concept) {
    //     // TODO : check it works for new narrower enum
    //     return $this->narrower()->attach([$concept => ["relationship_type" => "narrower"]]);
    // }


    public function addNarrower($conceptId) {
        // TODO : check it works for new narrower enum
        return $this->narrower()->attach([$conceptId => ["relationship_type" => "broader"]]);
    }

    public function sources() {
        return $this->hasMany("App\Models\ConceptSource");
    }

    public function conceptProperties() {
        return $this->hasMany("App\Models\ConceptProperty");
    }

    public function conceptCategories() {
        return $this->belongsToMany("App\Models\Vocabulary", "concept_categories", "concept_id", "category_id");
    }

}
