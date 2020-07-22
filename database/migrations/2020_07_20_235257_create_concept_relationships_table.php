<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concept_relationships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('concept_id')->unsigned();
            $table->bigInteger('related_concept_id')->unsigned();
            $table->enum('relationship_type', ['broader', 'narrower', 'related']);
            $table->foreign('concept_id')
                ->references('id')
                ->on('concepts');
            $table->foreign('related_concept_id')
                ->references('id')
                ->on('concepts');
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
        Schema::dropIfExists('concept_relationships');
    }
}
