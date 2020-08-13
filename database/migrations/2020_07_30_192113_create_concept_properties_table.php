<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("concept_properties", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->bigInteger("concept_id")->unsigned();
            $table->foreign("concept_id")
                ->references("id")->on("concepts");
            $table->text("type"); //scopeNote, definition, historyNote
            $table->text("value");
            $table->integer("language_id")->nullable()->unsigned();
            $table->foreign("language_id")
                ->references("id")
                ->on("vocabulary");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("concept_properties");
    }
}
