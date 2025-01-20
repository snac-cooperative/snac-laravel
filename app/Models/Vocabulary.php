<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "vocabulary";

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "type",
        "value",
        "description",
    ];

    protected $hidden = ["uri", "entity_group"];

    public function concept()
    {
        return $this->belongsTo("App\Models\Concept");
    }

    public static function conceptCategories()
    {
        return Vocabulary::where('type', 'concept_category');
    }

    public static function languageCodes()
    {
        return Vocabulary::where('type', 'language_code');
    }

    public static function english()
    {
        return Vocabulary::languageCodes()->where('value', 'eng')->firstOrFail();
    }
}
