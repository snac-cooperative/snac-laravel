<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    protected $fillable = [
        "deprecated" => "boolean"
    ];

    public function deprecatedTo() {
        return $this->hasOne("\App\Concept", "foreign_key","deprecated_to");
    }
}
