<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptNote extends Model {

    protected $fillable = [
        "note",
        "language_id",
        "type_id",
    ];
    protected $hidden = ["created_at", "updated_at"];


  public function concept() {
    return $this->belongsTo("App\Models\Concept");
  }

}
