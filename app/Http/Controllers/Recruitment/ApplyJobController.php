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
        date_default_timezone_set('Asia/Manila');
        $file 	= $request->file('attach_file');
        $input 						= $request->all();
        $input['application_date']  = date("Y-m-d");
        
        $getjobid = $request->input('job_id');
        
        $getjobname = DB::table('job')->where('job_id', $getjobid)->value('job_title');
        $getappname = $request->input('applicant_name');
        
        if($file){
            
            //$fileName = str_replace(' ', '', $file->getClientOriginalName());
            $fileName = md5(str_random(30).time().'_'.$request->file('attach_file')).'.'.$request->file('attach_file')->getClientOriginalExtension();
            $request->file('attach_file')->move('uploads/applicantResume/', $fileName);
            $input['attached_resume'] = $fileName;
        }
        
        $results = DB::table('job')->where('job_id', $getjobid)->first();
        $data = [
        'file' => $file,
        'getfilename' => $fileName,
        'fromadd' => $request->input('applicant_email')
        ];

        try{
            JobApplicant::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        
        $getid = "https://hris.livewire365.com/jobCandidate/applyCandidateList/".$getjobid;

        if($bug == 0){
            
            Mail::to('bryan@leentechsystems.com')->send(new SubmitApplication($data, $getappname, $getjobname, $getid));
            
            return redirect('lnsjobs')->with('success', 'Application successfully created.');
        }else {
            return redirect('lnsjobs')->with('error', 'Something Error Found !, Please try again.');
        }
    }
}
