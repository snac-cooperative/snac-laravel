<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptSource extends Model
{
    protected $fillable = [
        "concept_id",
        "citation",
        "url",
        "found_data",
        "note"
    ];

    public function concept() {
        return $this->belongsTo("\App\Models\Concept");
    }
}
