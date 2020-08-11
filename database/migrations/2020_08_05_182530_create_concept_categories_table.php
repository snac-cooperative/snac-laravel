<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concept_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('concept_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('concept_id')->references('id')
                ->on('concepts');
            $table->foreign('category_id')->references('id')
                ->on('vocabulary');
            $table->unique(['concept_id', 'category_id']);
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
        Schema::dropIfExists('concept_categories');
    }
}
