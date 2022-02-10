<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('text');
            $table->boolean('preferred');
            $table->integer('language_id')->nullable()->unsigned();
            $table->foreign('language_id')
                ->references('id')
                ->on('vocabulary');
            $table->bigInteger('concept_id')->unsigned();
            $table->foreign('concept_id')
                ->references('id')
                ->on('concepts');
            $table->timestamps();
            $table->index('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terms');
    }
}
