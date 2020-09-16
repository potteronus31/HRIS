<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;

use App\Http\Requests\JobPostRequest;

use App\Http\Controllers\Controller;

use App\Model\Job;

use DB;

class PublicJobController extends Controller
{
    //
    
    public function index()
    {
        
        $getdatenow = date('Y-m-d');
        $results = Job::with('createdBy')
                    ->where("publish_date", '<=' ,$getdatenow)
                    ->where("application_end_date", '>=', $getdatenow)
                    ->orderBy('job_id','DESC')->get();
                    
        return view('admin.recruitment.publicJob.index', ['result' => $results]);
    }
    
    public function show($id)
	{
        $results = Job::with(['createdBy'])->where('job_id',$id)->first();
        return view('admin.recruitment.publicJob.show',['result' => $results]);
    }
    
     public function storeapp($id)
	{
        $results = Job::with(['createdBy'])->where('job_id',$id)->first();
        return view('admin.recruitment.publicJob.apply',['result' => $results]);
    }

}
