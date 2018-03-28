<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriberInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('subscriber_infos', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('sid');
			$table->string('address1');
			$table->string('city1');
			$table->string('state1');
			$table->string('address2');
			$table->string('city2');
			$table->string('state2');
			$table->string('status');
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
        Schema::drop('subscriber_infos');
    }
}
