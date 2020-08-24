<?php

namespace App\Http\Controllers\Leave;

use App\Repositories\LeaveRepository;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Model\LeaveApplication;

use Illuminate\Http\Request;

use App\Model\Employee;

use App\Mail\ApproveLeave;

use App\Mail\RejectLeave;

use DB;

use Mail;



class RequestedApplicationController extends Controller
{
	
    protected $leaveRepository;

    public function __construct(LeaveRepository $leaveRepository){
        $this->leaveRepository  = $leaveRepository;
    }


    public function index(){
        $hasSupervisorWiseEmployee       = Employee::select('employee_id')->where('supervisor_id',session('logged_session_data.employee_id'))->get()->toArray();
        if(count($hasSupervisorWiseEmployee) == 0 ){
            $results = [];
        }else {
            $results  = LeaveApplication::with(['employee','leaveType'])
                        ->whereIn('employee_id',array_values($hasSupervisorWiseEmployee))
                        ->orderBy('status','asc')
                        ->orderBy('leave_application_id','desc')
                        ->get();
        }
        return view('admin.leave.leaveApplication.leaveApplicationList',['results'=>$results]);
    }


    public function viewDetails($id){
        $leaveApplicationData  = LeaveApplication::with(['employee'=>function($q){
            $q->with(['designation']);
        }])->with('leaveType')->where('leave_application_id',$id)->where('status',1)->first();

        if(!$leaveApplicationData){
            return response()->view('errors.404', [], 404);
        }

        $currentBalance        = $this->leaveRepository->calCulateEmployeeLeaveBalance($leaveApplicationData->leave_type_id,$leaveApplicationData->employee_id);
        return view('admin.leave.leaveApplication.leaveDetails',['leaveApplicationData' => $leaveApplicationData,'currentBalance' => $currentBalance]);
    }


    public function update(Request $request,$id){

        $data = LeaveApplication::findOrFail($id);
        
        $getleave = DB::table('leave_application')->where("leave_application_id", $id)->get();
        
        foreach($getleave as $employee)
        {
            $getemployeeid = $employee->employee_id;
            $getpurpose = $employee->purpose;
            $getdatefrom = $employee->application_from_date;
            $getdateto = $employee->application_to_date;
        }
        
        $getemail = DB::table('employee')->where('employee_id', $getemployeeid)->value("email");
        
        
        $input = $request->all();
        
        if($request->status == 2) {
            $input['approve_date']     = date('Y-m-d');
            $input['approve_by']       = session('logged_session_data.employee_id');
             $getdatenow = $input['approve_date'];
        }else{
            $input['reject_date']      = date('Y-m-d');
            $input['reject_by']        = session('logged_session_data.employee_id');
            $getdatenow = $input['reject_date'];
        }
        

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            if($request->status == 2) {
                
                Mail::to($getemail)->send(new ApproveLeave($getdatenow, $getpurpose, $getdatefrom, $getdateto));
                
                return redirect('requestedApplication')->with('success', 'Leave application approved successfully. ');
            }else{
                
                 Mail::to($getemail)->send(new RejectLeave($getdatenow, $getpurpose, $getdatefrom, $getdateto));
                
                return redirect('requestedApplication')->with('success', 'Leave application reject successfully. ');
            }
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }

    }

	
    public function approveOrRejectLeaveApplication(Request $request){

        $data = LeaveApplication::findOrFail($request->leave_application_id);
        $input = $request->all();
        
       $getid = $request->leave_application_id;
        
        $getleave = DB::table('leave_application')->where("leave_application_id", $getid)->get();
        
        foreach($getleave as $employee)
        {
            $getemployeeid = $employee->employee_id;
            $getpurpose = $employee->purpose;
            $getdatefrom = $employee->application_from_date;
            $getdateto = $employee->application_to_date;
        }
        
        $getemail = DB::table('employee')->where('employee_id', $getemployeeid)->value("email");
        
        

        if($request->status == 2) {
            $input['approve_date']     = date('Y-m-d');
            $input['approve_by']       = session('logged_session_data.employee_id');
            $getdatenow = $input['approve_date'];
        }else{
            $input['reject_date']      = date('Y-m-d');
            $input['reject_by']        = session('logged_session_data.employee_id');
            $getdatenow = $input['reject_date'];
        }

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            if($request->status == 2) {
                Mail::to($getemail)->send(new ApproveLeave($getdatenow, $getpurpose, $getdatefrom, $getdateto));
                echo "approve";
            }else{
                 Mail::to($getemail)->send(new RejectLeave($getdatenow, $getpurpose, $getdatefrom, $getdateto));
                echo "reject";
            }
        }else {
           echo "error";
        }
    }


}
