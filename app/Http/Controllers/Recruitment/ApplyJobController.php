<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\ApplicantUserRequest;

use Illuminate\Support\Facades\Auth;

use App\Model\JobApplicant;

use App\Mail\SubmitApplication;

use DB;

use Mail;

class ApplyJobController extends Controller
{
    
    
    //
   public function store(ApplicantUserRequest $request)
    {
        $file 	= $request->file('attach_file');
        $input 						= $request->all();
        $input['application_date']  = date("Y-m-d");
        
        $getjobid = $request->input('job_id');
        
        if($file){
            $fileName = md5(str_random(30).time().'_'.$request->file('attach_file')).'.'.$request->file('attach_file')->getClientOriginalExtension();
            $request->file('attach_file')->move('uploads/applicantResume/', $fileName);
            $input['attached_resume'] = $fileName;
        }
        
        $results = DB::table('job')->where('job_id', $getjobid)->first();
        $data = [
        'file' => $file
        ];

        try{
            JobApplicant::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            
            // Mail::to('bryan@leentechsystems.com')->send(new SubmitApplication($data));
            
            return redirect('lnsjobs')->with('success', 'Application successfully created.');
        }else {
            return redirect('lnsjobs')->with('error', 'Something Error Found !, Please try again.');
        }
    }
}
