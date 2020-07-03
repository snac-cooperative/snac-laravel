<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
  public function concept() {
    return $this->belongsTo("App\Concept");
  }

  protected $fillable = [
    "term_text",
    "preferred" => "boolean"
  ];
    //
}
