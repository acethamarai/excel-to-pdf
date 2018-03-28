<?php
namespace App\Http\Controllers;
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use App\Batch;
use App\User;
use App\Payslip;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
class MyexcelController extends Controller {

    public function importExport()
	{
		return view('importExport');
	}
	public function downloadExcel($type)
	{
		$data = Item::get()->toArray();
		return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}
	public function import_salary_sheet(Request $request)
	{
		 if($request->hasFile('excel')){
            $path = $request->file('excel')->getRealPath();
            $data = \Excel::load($path)->get();
			//print_r($data);exit;
			$batch = [
					'gen_date' => date('Y/m/d'),
					'gen_user' => Auth::user()->id,
					'status' => 1,
					];
			Batch::insert($batch);
            if($data->count()){
                foreach ($data as $key => $value) {
                   $arr = [
					'bid' => $value->bid,
					'emp_id' => $value->emp_id,
					'emp_name' => $value->name,
					'gender' => $value->gender,
					'designation' => $value->designation,
					'bank_name' => $value->bank_name,
					'bank_ac' => $value->bank_ac_no,
					'pf_no' => $value->pf_no,
					'month_slip' => $value->month,
					'lop' => $value->lop,
					'annual_ctc' => $value->annual_ctc,
					'month_ctc' => $value->monthly_ctc,
					'no_of_days' => 30,
					'basic' => $value->basic,
					'hra' => $value->hra,
					'spl_al' => $value->spl_al,
					'gross' => $value->gross,
					'pf_empe' => $value->pf_employee,
					'pf_empr' => $value->pf_employer,
					'pt_other' => $value->pt_other,
					'net_salary' => $value->net_salary,
					];
                Payslip::insert($arr);
				}
				$message = "Information Imported from Excel successfully ";
    			Session::flash('success', $message);
    			return redirect()->route('importexcel');	
            }
		} else {
    		$message = "Please Select Excel File ";
    		Session::flash('error', $message);
    		return redirect()->route('importexcel');
    	}
        return back(); 
	}
}