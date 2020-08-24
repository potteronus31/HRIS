<?php
namespace App\Repositories;

use App\Model\EmployeeAttendanceApprove;
use App\Model\SalaryDeductionForLateAttendance;

use App\Model\PayGradeToAllowance;

use App\Model\PayGradeToDeduction;

use Illuminate\Support\Facades\DB;

use App\Model\TaxRule;

use Carbon\Carbon;

use DateTime;


class PayrollRepository
{

    protected $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository    = $attendanceRepository;
    }


    public function pay_grade_to_allowance($pay_grade_id)
    {
        return  PayGradeToAllowance::select('allowance.*')
                                     ->join('allowance', 'allowance.allowance_id', '=', 'pay_grade_to_allowance.allowance_id')
                                     ->where('pay_grade_id',$pay_grade_id)->get();
    }


    public function pay_grade_to_deduction($pay_grade_id)
    {
        return  PayGradeToDeduction::select('deduction.*')
                                    ->join('deduction', 'deduction.deduction_id', '=', 'pay_grade_to_deduction.deduction_id')
                                    ->where('pay_grade_id',$pay_grade_id)->get();
    }


    public function calculateEmployeeAllowance($basic_salary,$pay_grade_id)
    {
        $allowances     = $this->pay_grade_to_allowance($pay_grade_id);
        $allowanceArray = [];
        $totalAllowance = 0;
        foreach ($allowances as $key => $allowance){
            $temp                           = [];
            $temp['allowance_id']           = $allowance->allowance_id;
            $temp['allowance_name']         = $allowance->allowance_name;
            $temp['allowance_type']         = $allowance->allowance_type;
            $temp['percentage_of_basic']    = $allowance->percentage_of_basic;
            $temp['limit_per_month']        = $allowance->limit_per_month;

            if($allowance->allowance_type == 'Percentage'){
                $percentageOfAllowance = ($basic_salary * $allowance->percentage_of_basic) / 100;
                 if($allowance->limit_per_month !=0 && $percentageOfAllowance >= $allowance->limit_per_month){
                     $temp['amount_of_allowance'] = $allowance->limit_per_month;
                 }else {
                     $temp['amount_of_allowance'] = $percentageOfAllowance;
                 }
            }else{
                $temp['amount_of_allowance'] = $allowance->limit_per_month;
            }
            $totalAllowance +=$temp['amount_of_allowance'];
            $allowanceArray[$key] = $temp;
        }

        return ['allowanceArray'=>$allowanceArray, 'totalAllowance'=>$totalAllowance];
    }



    public function calculateEmployeeDeduction($basic_salary,$pay_grade_id)
    {
        $deductions     = $this->pay_grade_to_deduction($pay_grade_id);
        $deductionArray = [];
        $totalDeduction = 0;
        foreach ($deductions as $key => $deduction){
            $temp                           = [];
            $temp['deduction_id']           = $deduction->deduction_id;
            $temp['deduction_name']         = $deduction->deduction_name;
            $temp['deduction_type']         = $deduction->deduction_type;
            $temp['percentage_of_basic']    = $deduction->percentage_of_basic;
            $temp['limit_per_month']        = $deduction->limit_per_month;

            if($deduction->deduction_type == 'Percentage'){
                $percentageOfDeduction = ($basic_salary * $deduction->percentage_of_basic) / 100;
                if($deduction->limit_per_month !=0 && $percentageOfDeduction >= $deduction->limit_per_month){
                    $temp['amount_of_deduction'] = $deduction->limit_per_month;
                }else {
                    $temp['amount_of_deduction'] = $percentageOfDeduction;
                }
            }else{
                $temp['amount_of_deduction'] = $deduction->limit_per_month;
            }
            $totalDeduction +=$temp['amount_of_deduction'];
            $deductionArray[$key] = $temp;
        }
        return ['deductionArray'=>$deductionArray, 'totalDeduction'=>$totalDeduction];
    }

    /**
     *
     * @employee tax calculation
     *
     *
     */

    public function calculateEmployeeTax($gross_salary,$basic_salary,$date_of_birth,$gender,$pay_grade_id)
    {
        $result     = $this->calculateEmployeeAllowance($basic_salary,$pay_grade_id);
        $birthday   = $this->getEmployeeAge($date_of_birth);
        $tax    = 0;
        $tax = $gross_salary - $result['totalAllowance'];
        $totalTax = $tax * 12;
        if($birthday >= 65 || $gender == 'Female'){
            $taxRule = TaxRule::where('gender','Female')->get();
        }else{
            $taxRule = TaxRule::where('gender','Male')->get();
        }

        $yearlyTax = 0;
        foreach ($taxRule as $value){
            if($totalTax <= 0){
                break;
            }
            if($totalTax >= $value->amount && $value->amount !=0){
                $yearlyTax +=($value->amount * $value->percentage_of_tax) / 100;
                $totalTax = $totalTax -$value->amount;
            }else{
                $yearlyTax +=($totalTax * $value->percentage_of_tax) / 100;
                 $totalTax = $totalTax - $totalTax;
            }
        }

        $monthlyTax = 0;
        if($yearlyTax !=0){
            $monthlyTax = $yearlyTax / 12;
        }
        $data =[
            'monthlyTax'          => round($monthlyTax),
            'taxAbleSalary'          => $tax,
        ];

        return $data;
    }


    public function getEmployeeAge($date_of_birth)
    {
        $birthday = new DateTime ($date_of_birth);
        $currentDate = new DateTime ( 'now' );
        $interval = $birthday->diff ( $currentDate );
        return $interval->y;
    }



    /**
     *
     * @employee total working days
     * @employee total leave
     * @employee total late             @@ getEmployeeOtmAbsLvLtAndWokDays()
     * @employee total late amount
     * @employee total over time
     * @employee total present
     *
    */


    public function getEmployeeOtmAbsLvLtAndWokDays($employee_id,$month,$overtime_rate,$basic_salary){

        $getDate = $this->getMonthToStartDateAndEndDate($month);
        $queryResult =  $this->attendanceRepository->getEmployeeMonthlyAttendance($getDate['firstDate'], $getDate['lastDate'],$employee_id);

        $overTime = [];
        $totalPresent = 0;
        $totalAbsence = 0;
        $totalLeave   = 0;
        $totalLate    = 0;
        $totalLateAmount    = 0;
        $totalAbsenceAmount    = 0;
        $totalWorkingDays    = count($queryResult);

        foreach ($queryResult as $value){
            if($value['action'] =='Absence'){
                $totalAbsence +=1;
            }elseif($value['action'] =='Leave'){
                $totalLeave +=1;
            }else{
                $totalPresent +=1;
            }

            if($value['ifLate'] == 'Yes'){
                $totalLate +=1;
            }

            $workingHour = new DateTime($value['workingHour']);
            $workingTime = new DateTime($value['working_time']);
            if($workingHour < $workingTime){
                $interval = $workingHour->diff($workingTime);
                $overTime[]= $interval->format('%H:%I');
            }
        }

        /**
         * @employee Salary Deduction For Late Attendance
        */

        $salaryDeduction = SalaryDeductionForLateAttendance::where('status','Active')->first();
        $dayOfSalaryDeduction = 0;
        $oneDaysSalary = 0;
        if($basic_salary!=0 && $totalWorkingDays!=0 && $totalLate !=0 && !empty($salaryDeduction)){
            $numberOfDays = 0;
             for($i=1;$i<=$totalLate;$i++){
                 $numberOfDays++;
                 if($numberOfDays == $salaryDeduction->for_days){
                     $dayOfSalaryDeduction +=1;
                     $numberOfDays = 0;
                 }
             }

            $oneDaysSalary = $basic_salary / $totalWorkingDays;
            $totalLateAmount = $oneDaysSalary * $dayOfSalaryDeduction;

        }

        /**
        * @employee Salary Deduction For absence
        */

        if($totalAbsence !=0 && $basic_salary!=0 && $totalWorkingDays!=0){
           $perDaySalary = $basic_salary /$totalWorkingDays;
           $totalAbsenceAmount = $perDaySalary * $totalAbsence;
        }

        $oneDaySalary = $basic_salary /$totalWorkingDays;

        $overTime = $this->calculateEmployeeTotalOverTime($overTime,$overtime_rate);
        $data =[
            'overtime_rate'          => $overtime_rate,
            'totalOverTimeHour'      => $overTime['totalOverTimeHour'],
            'totalOvertimeAmount'    => $overTime['overtimeAmount'],
            'totalPresent'           => $totalPresent,
            'totalAbsence'           => $totalAbsence,
            'totalAbsenceAmount'     => round($totalAbsenceAmount),
            'totalLeave'             => $totalLeave,
            'totalLate'              => $totalLate,
            'dayOfSalaryDeduction'   => $dayOfSalaryDeduction,
            'totalLateAmount'        => round($totalLateAmount),
            'totalWorkingDays'       => $totalWorkingDays,
            'oneDaysSalary'          => $oneDaySalary,
        ];

        return $data;
    }



    public function calculateEmployeeTotalOverTime($overTime, $overtime_rate)
    {

        $totalMinute = 0;
        $minuteWiseAmount = 0;
        $hour = 0;
        $minutes = 0;
        foreach($overTime  as $key => $value) {

            $value = explode(':',$value);
            $hour += $value[0];
            $minutes += $value[1];
            if($minutes>=60){
                $minutes -= 60;
                $hour ++;
            }
        }
        $hours   = $hour.':'.(($minutes<10)?'0'.$minutes:$minutes);
        $value   = explode(':',$hours);
        $totalMinute = $value[1];
        if($totalMinute !=0 && $overtime_rate!=0){

            $perMinuteAmount = $overtime_rate / 60;
            $minuteWiseAmount = $perMinuteAmount * $totalMinute;

        }
         $overtimeAmount = ($value[0] * $overtime_rate) + $minuteWiseAmount;


        return ['totalOverTimeHour' => $hours,'overtimeAmount' => round($overtimeAmount)];
    }



    public function getMonthToStartDateAndEndDate($month){

        $month = explode('-',$month);
        $current_year = $month[0];
        $lastMonth    = $month[1];

        $firstDate = $current_year."-".$lastMonth."-01" ;
        $lastDateOfMonth = date('t',strtotime($firstDate));
        $lastDate = $current_year."-".$lastMonth."-".$lastDateOfMonth ;

        return['firstDate'=>$firstDate,'lastDate'=>$lastDate];

    }


    public function getEmployeeHourlySalary($employee_id,$month,$hourly_rate){
        $getDate     = $this->getMonthToStartDateAndEndDate($month);
        $queryResult = EmployeeAttendanceApprove::where('employee_id',$employee_id)->whereBetween('date', [$getDate['firstDate'], $getDate['lastDate']])->get()->toArray();

        $totalAmountOfSalary = 0;
        $hour    = 0;
        $minutes = 0;
        foreach ($queryResult as $value){
            if($value['approve_working_hour'] =='00:00' || $value['approve_working_hour'] == ''){
                continue;
            }
            $value = explode(':',date('H:i', strtotime($value['approve_working_hour'])));
            $hour += $value[0];
            $minutes += $value[1];
            if($minutes>=60){
                $minutes -= 60;
                $hour ++;
            }
        }

        $totalTime   = $hour.':'.(($minutes<10)?'0'.$minutes:$minutes);
        $perMinuteAmount = $hourly_rate / 60;
        $minuteWiseAmount = $perMinuteAmount * (($minutes<10)?'0'.$minutes:$minutes);

        $totalAmountOfSalary = ($hour * $hourly_rate) + $minuteWiseAmount;;

        $data = [
            'totalWorkingHour' =>  $totalTime,
            'totalSalary' =>  round($totalAmountOfSalary),
        ];
        return $data;

    }




}
