<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        "text",
        "preferred",
        "concept_id",
        "language_id",
    ];

    protected $hidden = ["created_at", "updated_at"];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ["language"];


    public function concept()
    {
        return $this->belongsTo(\App\Models\Concept::class);
    }

    public function language()
    {
        return $this->belongsTo(\App\Models\Vocabulary::class, 'language_id');
    }
}
