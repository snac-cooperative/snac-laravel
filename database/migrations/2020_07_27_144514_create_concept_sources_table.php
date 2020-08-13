<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("concept_sources", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->bigInteger("concept_id")->unsigned();
            $table->foreign("concept_id")
                ->references("id")->on("concepts");
            $table->text("citation")->nullable();
            $table->text("url")->nullable();
            $table->text("found_data")->nullable();
            $table->text("note")->nullable();
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
        Schema::dropIfExists("concept_sources");
    }
}
