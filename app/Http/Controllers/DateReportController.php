<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\JobPostRequest;

use App\Http\Controllers\Controller;

use App\Model\Job;

use DB;

class DateReportController extends Controller
{
    //   

    public function index()
    {
        $select = DB::table('job')->get();
        
        foreach($select as $getlist)
        {
            
            echo $getjobtitle = $getlist->job_title;
            
        }
    }
}
