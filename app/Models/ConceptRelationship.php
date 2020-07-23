<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptRelationship extends Pivot
{
    protected $fillable = [
        "deprecated",
    ];
}
