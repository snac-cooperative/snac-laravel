<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model {

    protected $fillable = [
        "text",
        "preferred"
    ];

  public function concept() {
    return $this->belongsTo("App\Models\Concept");
  }

}
