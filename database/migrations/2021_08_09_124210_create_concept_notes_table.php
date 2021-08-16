<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concept_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('concept_id')->unsigned();
            $table->bigInteger('language_id')->unsigned();
            $table->bigInteger('type_id')->unsigned();
            $table->text("note");
            $table->foreign('language_id')->references('id')
                ->on('vocabulary');
            $table->foreign('type_id')->references('id')
                ->on('vocabulary');
            $table->timestamps();
        });

        if (DB::table('vocabulary')->where('type','concept_note_type')->doesntExist()){
            DB::table('vocabulary')->insert([
                [
                    'type' => 'concept_note_type',
                    'value' => 'scope',
                    'description' =>'Notes associated to Concepts to specify the scope'
                ],
                [
                    'type' => 'concept_note_type',
                    'value' => 'historical',
                    'description' =>'Notes associated to Concepts for historical information'
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concept_notes');
    }
}
