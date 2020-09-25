<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model {

    protected $fillable = [
        "text",
        "preferred",
        "concept_id",
    ];
    protected $hidden = ["created_at", "updated_at"];


  public function concept() {
    return $this->belongsTo("App\Models\Concept");
  }

}
