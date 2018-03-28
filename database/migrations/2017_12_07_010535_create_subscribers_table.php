<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mob_no');
            $table->string('activation_date');
			$table->string('balance');
			$table->string('service_class');
			$table->string('language');
			$table->string('service_period');
			$table->string('temp_service_exp');
			$table->string('max_service_period_expiry');
			$table->string('max_supervision_expiry');
			$table->string('balance_bar_date');
			$table->string('credit_clearance');
			$table->string('validity_expiry');
			$table->string('barred_date');
			$table->string('hlr_profile');
			$table->string('sim');
			$table->string('puk1');
			$table->string('puk2');
			$table->string('imsi');
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
        Schema::drop('subscribers');
    }
}
