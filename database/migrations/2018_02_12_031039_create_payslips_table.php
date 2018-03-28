<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('bid');
			$table->string('emp_id');
            $table->string('emp_name');
			$table->string('gender');
			$table->string('designation');
			$table->string('bank_name');
			$table->string('bank_ac');
			$table->string('pf_no');
			$table->string('month_slip');
			$table->string('lop');
			$table->string('annual_ctc');
			$table->string('month_ctc');
			$table->string('no_of_days');
			$table->string('basic');
			$table->string('hra');
			$table->string('spl_al');
			$table->string('gross');
			$table->string('pf_empe');
			$table->string('pf_empr');
			$table->string('pt_other');
			$table->string('net_salary');
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
        Schema::dropIfExists('payslips');
    }
}
