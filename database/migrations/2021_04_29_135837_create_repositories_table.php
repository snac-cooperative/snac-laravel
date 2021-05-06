<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('repository_name_unauthorized')->nullable();
            $table->text('name_notes_description')->nullable();
            $table->text('parent_org_unauthorized')->nullable();
            $table->text('repository_name_authorized')->nullable();
            $table->text('repository_identifier_authorized')->nullable();
            $table->text('repository_type')->nullable();
            $table->text('location_type')->nullable();
            $table->text('street_address_1')->nullable();
            $table->text('street_address_2')->nullable();
            $table->text('st_city')->nullable();
            $table->text('postal_code')->nullable();
            // $table->text('st_zip_code_5_numbers')->nullable();
            // $table->text('st_zip_code_4_following_numbers')->nullable();
            $table->text('street_address_county')->nullable();
            $table->text('state_province')->nullable();
            $table->text('country')->nullable();
            $table->text('url')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->text('language_of_entry  =>')->nullable();
            $table->text('date_entry_recorded')->nullable();
            $table->text('entry_recorded_by')->nullable();
            $table->text('source_of_repository_data')->nullable();
            $table->text('url_of_source_of_repository_data')->nullable();
            $table->text('notes')->nullable();
            $table->text('geocode_confidence')->nullable();
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
        Schema::dropIfExists('repositories');
    }
}
