<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptProperty extends Model
{
    protected $fillable = [
                "type",
                "value",
            ];

    public function concept() {
        return $this->belongsTo("App\Models\Concept");
    }
}
