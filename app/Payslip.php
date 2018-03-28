<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
	  public $fillable = ['bid','emp_id','emp_name','gender','designation','bank_name','bank_ac','pf_no','month_slip','lop','annual_ctc','month_ctc','no_of_days','basic','hra','spl_al','gross','pf_empe','pf_empr','pt_other','net_salary'];
}
