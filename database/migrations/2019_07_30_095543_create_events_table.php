<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',255);
            $table->text('description');
            $table->string('fb_url')->nullable();
            $table->string('place_text')->nullable();
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->boolean('approved');
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('place_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('contact_id');
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
        Schema::dropIfExists('events');
    }
}
