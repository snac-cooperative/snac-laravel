<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityConcept extends Model
{
    protected $fillable = [
        "id",
        "version",
        "ic_id",
        "type",
        "is_deleted",
        "concept_id",
    ];

    public $timestamps = false;  //consider adding them

    public function concept() {
        return $this->belongsTo("App\Models\Concept");
    }

}
