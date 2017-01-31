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
      $table->increments('id');
      $table->integer('address_id')->unsigned();
      $table->foreign('address_id')->references('id')->on('addresses');

      $table->string('name');
      $table->text('description');
      $table->string('url');
      $table->string('venue');
      $table->dateTime('start_date');
      $table->dateTime('end_date')->nullable();
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
