<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    protected $fillable = [
        "deprecated"
    ];

    public function deprecatedTo() {
        return $this->hasOne("\App\Models\Concept", "foreign_key","deprecated_to");
    }

    public function terms() {
        return $this->hasMany("App\Models\Term");
    }
}
