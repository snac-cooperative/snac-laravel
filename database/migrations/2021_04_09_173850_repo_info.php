<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RepoInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repo_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('repo_data_id')->nullable();
            $table->text('repository_name_authorized')->nullable();
            $table->text('repository_name_unauthorized')->nullable();
            $table->text('name_notes')->nullable();
            $table->text('parent_org_unauthorized')->nullable();
            $table->text('repository_type')->nullable();
            $table->text('location_type')->nullable();
            $table->text('street_address_1')->nullable();
            $table->text('street_address_2')->nullable();
            $table->text('st_city')->nullable();
            $table->text('st_zip_code_5_numbers')->nullable();
            $table->text('st_zip_code_4_following_numbers')->nullable();
            $table->text('street_address_county')->nullable();
            $table->text('state')->nullable();
            $table->text('url')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->text('language_of_entry')->nullable();
            $table->text('source_of_repository_data')->nullable();
            $table->text('url_of_source_of_repository_data')->nullable();
            $table->text('notes')->nullable();
            $table->float('geocode_confidence')->nullable();
            $table->timestamps();
            // $table->foreign('ic_id')
            // ->references('id')
            //     ->on('version_history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repo_info');
    }
}


// id
// repository_name_authorized
// repository_name_unauthorized
// name_notes
// parent_org_unauthorized
// repository_type
// location_type
// street_address_1
// street_address_2
// st_city
// st_zip_code_5_numbers
// st_zip_code_4_following_numbers
// street_address_county
// state
// url
// latitude
// longitude
// language_of_entry
// source_of_repository_data
// url_of_source_of_repository_data
// notes
// geocode_confidence



// NOT INCLUDED
    // repository_identifier_authorized  // Only one in repo_data
    // date_entry_recorded
    // entry_recorded_by

// DATA MODEL QUESTIONS
    // Are we going to go with our standard CPF Name tables, place tables, etc? 

// ADDRESS QUESTIONS
    // street_address_1
    // street_address_2
    // st_city
    // st_zip_code_5_numbers
    // st_zip_code_4_following_numbers
    // street_address_county
    // state

    // how do we want to represent addresses?
    // We'll want to do these internationally for sure...
    // Integrate into current existing address/lat/long? or include
    // Only one address per repo?