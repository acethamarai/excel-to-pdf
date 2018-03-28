<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Payslip;
use App\Batch;
use App\User;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;
use Yajra\Datatables\Facades\Datatables;
use PDF;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
	public function getDashboard(Request $request)
	{
		$data['page_title'] = 'Dashboard';
		/*
		$data['bat_info'] = DB::table('batches')
            ->leftJoin('users', 'batches.gen_user', '=', 'users.id')
            ->leftJoin('payslips', 'batches.id', '=', 'payslips.bid')
            ->select('batches.id as id','batches.status as status',DB::raw('count(payslips.bid) as count'))->groupBy('batches.id')
            ->get();
		*/	
		$bat_info = DB::table('batches')
            ->leftJoin('users', 'batches.gen_user', '=', 'users.id')
            ->select('batches.id','batches.gen_date','batches.status','users.name')->get();
		//dd($bat_info);	
		foreach($bat_info as $val){
			$data['bat_info'][] =array(
				'id'=>$val->id,
				'gen_date'=>$val->gen_date,
				'status'=>$val->status,
				'tcount'=>$this->payslipcount($val->id),
				'name'=>$val->name
				);
		}
		
		return view('index',$data);
	}
	public function payslipcount($bid){
		$count=Payslip::where('bid',$bid)->count();
		return $count;
	}
	public function batchgendate($bid){
		$info=Batch::where('id',$bid)->select('gen_date')->first();
		$tmp = explode('/', $info->gen_date);
		$date = $tmp[2] . '/' . $tmp[1] . '/' . $tmp[0];
		return $date;
	}
	public function getBatch($batchid)
	{
		$data['page_title'] = 'Batch No: '.$batchid;
		$user_id=Auth::user()->id;
		$data['batch'] = Payslip::where('bid', $batchid)->get();
		$data['page_description'] = 'Data Count: '.$this->payslipcount($batchid).' | Uploaded on: '.$this->batchgendate($batchid);
		return view('batch_list',$data);
	}
	public function deleteBatch($batch_id)
	{
		Batch::where('id', $batch_id)->update(['status'=>0]);
		Payslip::where('bid', $batch_id)->delete();
		return redirect()->route('home');
	}
	public function deletePayslip($tblid)
	{
		Payslip::where('id', $tblid)->delete();
		return back();
	}
	public function getExportPDF(Request $request)
	{
		$items = DB::table("payslips")->where('id', $request->tblid)->get();
		view()->share('payslips',$items);
	
	
		if($request->has('download')){
			$pdf = PDF::loadView('payslip_pdf');
			return $pdf->download('payslip-pdf.pdf');
		}
	
	
		return view('payslip_pdf');
	}
	public function postExportBulkPDF(Request $request)
	{
		//dd($request->input());
		foreach($request->paysliplist as $tblid){
		//dd($tblid);	
		$items = DB::table("payslips")->where('id', $tblid)->get();
		view()->share('payslips',$items);
	
			$pdf = PDF::loadView('payslip_pdf');
			return $pdf->download('payslip-pdf.pdf');
		}
	
	
		return view('payslip_pdf');
	}
	public function postSubscriber(Request $request)
	{
		$this->validate($request, [
            'mob_no' => 'required'
        ]);
		$data['page_title'] = 'Search Subscriber';
		//dd($request->input('mob_no'));
		//SessionStore('mob_no',$request->input('mob_no'));
		//$data['sess'] = $request->session()->all();
		return redirect()->route('dashboard');
		
	}
	public function getSubscriberinfos(Request $request)
	{
		$data['sess']=array();
		$data['page_title'] = 'Search Subscriber';
		$user_id=Auth::user()->id;
		$data['subscriber'] = Subscriber::where('status', 1)->get()->toArray();
		$data['sess'] = $request->session()->all();
		return view('subscriber_information',$data);
	}
	public function getImportexcel(Request $request)
	{
		$data['sess']=array();
		$data['page_title'] = 'Import Payslip Excel Sheet';
		$user_id=Auth::user()->id;
		//$data['subscriber'] = Subscriber::where('status', 1)->get()->toArray();
		//$data['sess'] = $request->session()->all();
		return view('import_payslip_excel',$data);
	}		
	public function postImportexcel(Request $request)
	{
		$data['page_title'] = 'Import Payslip Sheet';
		//$help = new societyhelp;
    		$types = array('xls', 'XLS', 'xlsx', 'XLSX');
    		$fileName = "excel.xls";
    		if ($request->hasFile('excel')) {
    			$extension = $request->file('excel')->getClientOriginalExtension();
    			if (in_array($extension, $types)) {
    				//  echo 'yes';
    				 
    				if (file_exists('excel.csv')) {
    					unlink('excel.csv');
    				}
    				if (file_exists('excel.xls')) {
    					unlink('excel.xls');
    				}
    				 
    				move_uploaded_file($_FILES["excel"]["tmp_name"], 'excel.xls');
    				$ss = new MyexcelController();
    				 
    				$result = $ss->import_salary_sheet();
    				if (isset($result['status'])) {
    					if ($result['status'] == "failed") {
    						$message = $result['message'];
    						Session::flash('error', $message);
    						return redirect()->route('importexcel');
    					} else {
    						$message = "Information Imported from Excel successfully ";
    						Session::flash('success', $message);
    						return redirect()->route('importexcel');
    					}
    				} else {
    					$message = "Information Imported from Excel successfully ";
    					Session::flash('success', $message);
    					return redirect()->route('importexcel');
    				}
    			} else {
    				 
    				 
    				$message = "Please Select Excel File ";
    				Session::flash('error', $message);
    				return redirect()->route('importexcel');
    			}
    			 
    		}
    }
}
