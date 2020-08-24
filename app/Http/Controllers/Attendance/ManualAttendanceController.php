<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;

use App\Model\EmployeeAttendance;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

use App\Model\Department;

use App\Model\Employee;

use Carbon\Carbon;


class ManualAttendanceController extends Controller
{

    public function manualAttendance()
	{
        $departmentList = Department::get();
        return view('admin.attendance.manualAttendance.index',['departmentList'=>$departmentList]);

    }



    public function filterData(Request $request)
	{
        $data           = dateConvertFormtoDB($request->get('date'));
        $department     = $request->get('department_id');
        $departmentList = Department::get();

        $attendanceData = Employee::select('employee.finger_id','employee.department_id',
                            DB::raw('CONCAT(COALESCE(employee.first_name,\'\'),\' \',COALESCE(employee.last_name,\'\')) as fullName'),

                            DB::raw('(SELECT DATE_FORMAT(MIN(view_employee_in_out_data.in_time), \'%h:%i %p\')  FROM view_employee_in_out_data
                                                             WHERE view_employee_in_out_data.date = "'.$data.'" AND view_employee_in_out_data.finger_print_id = employee.finger_id ) AS inTime'),

                            DB::raw('(SELECT DATE_FORMAT(MAX(view_employee_in_out_data.out_time), \'%h:%i %p\') FROM view_employee_in_out_data
                                                             WHERE view_employee_in_out_data.date =  "'.$data.'" AND view_employee_in_out_data.finger_print_id = employee.finger_id ) AS outTime'))
                            ->where('employee.department_id',$department)
                            ->where('employee.status',1)
                            ->get();

        return view('admin.attendance.manualAttendance.index',['departmentList'=>$departmentList,'attendanceData'=>$attendanceData]);
    }


    public function store(Request $request)
	{

        date_default_timezone_set('Asia/Manila');
        $finger_print_ids = $request->Input(['fingerid']);
        $name = DB::table('employee')->where('finger_id', $finger_print_ids)->get();

        foreach ($name as $getdata) {
            # code...
            $departmenthere = $getdata->department_id;
        }

        $countme = DB::table('employee_attendance')->whereDate('in_out_time', DATE('Y-m-d'))->count();
        // $getidcount = DB::table('employee_attendance')->where('finger_print_id', $finger_print_ids)->count();

        $count = DB::table(DB::raw('employee_attendance'))->where('finger_print_id', $finger_print_ids)->get();
                foreach ($count as $exist) {
                    $getdate = $exist->in_out_time;
                    $format1 = 'Y-m-d';
                    $format2 = 'H:i:s';
                    $date = Carbon::parse($getdate)->format($format1);
                    $time = Carbon::parse($getdate)->format($format2);
                }

        // DB::insert('insert into employee_attendance (finger_print_id, in_out_time, created_at, updated_at) values(:finger_print_id, :in_out_time, :created_at, :updated_at)', ['finger_print_id'=>$finger_print_id,
        //     'in_out_time'=>$getdate,
        //     'created_at'=>$getdate,
        //     'updated_at'=>$getdate]);


         try{
            DB::beginTransaction();
                $data           = $request->get('date');
                $department     = $departmenthere;

                $result = json_decode(DB::table(DB::raw("(SELECT employee_attendance.*,employee.`department_id`,  DATE_FORMAT(`employee_attendance`.`in_out_time`,'%Y-%m-%d') AS `date` FROM `employee_attendance`
                    INNER JOIN `employee` ON `employee`.`finger_id` = employee_attendance.`finger_print_id`
                    WHERE department_id = $department) as employeeAttendance"))
                    ->select('employeeAttendance.employee_attendance_id')
                    ->where('employeeAttendance.finger_print_id',$finger_print_ids)
                    ->where('employeeAttendance.date',$data)
                    ->get()->toJson(),true);

                DB::table('employee_attendance')->whereIn('employee_attendance_id',array_values($result))->delete();

                foreach ($finger_print_ids as  $key => $finger_print_id)
                {

                    if(Input::get('timein') && isset($request->inTime[$key])) {


                             $InData = [
                            'finger_print_id'       => $finger_print_id,
                            'in_out_time'           => $data. ' ' .date("H:i:s", strtotime($request->inTime[$key])),
                            'created_at'            => Carbon::now(),
                            'updated_at'            => Carbon::now(),
                        ];
                         EmployeeAttendance::insert($InData);    

                        }


                    else if(Input::get('timeout') && isset($request->outTime[$key])) {

                        if($countme = 1)
                        {

                            $InData = [
                            'finger_print_id'       => $finger_print_id,
                            'in_out_time'           => $date. ' ' .$time,
                            'created_at'            => Carbon::now(),
                            'updated_at'            => Carbon::now(),
                        ];
                         EmployeeAttendance::insert($InData);

                             $outData = [
                            'finger_print_id'       => $finger_print_id,
                            'in_out_time'           => $data. ' ' .date("H:i:s", strtotime($request->outTime[$key])),
                            'created_at'            => Carbon::now(),
                            'updated_at'            => Carbon::now(),
                        ];
                        EmployeeAttendance::insert($outData);
                        }
                      
                    }
                }
            DB::commit();
            $bug = 0;
        }
        catch(\Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('manualAttendance')->with('success', 'Attendance successfully saved.');
        }else {
            return redirect('manualAttendance')->with('error', 'Something Error Found!, Please try again.');
        }

    }

}
