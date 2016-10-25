<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citynexus_properties', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('location_id')->unsigned()->nullable();
            $table->string('street_number')->nullable();
            $table->string('street_name')->nullable();
            $table->string('street_type')->nullable();
            $table->string('unit')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->integer('map')->nullable();
            $table->string('lot')->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_building')->default(false);
            $table->boolean('is_unit')->default(false);
            $table->integer('unit_of')->nullable();
            $table->boolean('is_lot')->default(false);
            $table->boolean('review')->default(false);
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
        Schema::drop('citynexus_properties');
    }

}
