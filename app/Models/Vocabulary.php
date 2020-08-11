<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model {

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = "vocabulary";

    protected $fillable = [
        "id",
        "type",
        "value",
        "uri",
        "description",
        "entity_group",
    ];

    public function concept() {
        return $this->belongsTo("App\Models\Concept");
    }

}
