<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();
        DB::table('menus')->insert(
            array
            (

                /**
                 *
                 * @user management
                 *
                 */

                array('parent_id' => 0,'action'=>NULL,'name'  => 'User', 'menu_url'  => 'user.index', 'module_id'  => '1', 'status'  => '2'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Manage Role', 'menu_url'  => NULL, 'module_id'  => '1', 'status'  => '1'),
                array('parent_id' => 2,'action'=>NULL,'name'  => 'Add Role', 'menu_url'  => 'userRole.index', 'module_id'  => '1', 'status'  => '1'),
                array('parent_id' => 2,'action'=>NULL,'name'  => 'Add Role Permission', 'menu_url'  => 'rolePermission.index', 'module_id'  => '1', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Change Password', 'menu_url'  => 'changePassword.index', 'module_id'  => '1', 'status'  => '1'),

                /**
                 *
                 * @employee management
                 *
                 */

                array('parent_id' => 0,'action'=>NULL,'name'  => 'Department', 'menu_url'  => 'department.index', 'module_id'  => '2', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Designation', 'menu_url'  => 'designation.index', 'module_id'  => '2', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Branch', 'menu_url'  => 'branch.index', 'module_id'  => '2', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Manage Employee', 'menu_url'  => 'employee.index', 'module_id'  => '2', 'status'  => '1'),

                /**
                 *
                 * @leave management
                 *
                 */

                array('parent_id' => 0,'action'=>NULL,'name'  => 'Setup', 'menu_url'  => null, 'module_id'  => '3', 'status'  => '1'),
                array('parent_id' => 10,'action'=>NULL,'name'  => 'Manage Holiday', 'menu_url'  => 'holiday.index', 'module_id'  => '3', 'status'  => '1'),
                array('parent_id' => 10,'action'=>NULL,'name'  => 'Public Holiday', 'menu_url'  => 'publicHoliday.index', 'module_id'  => '3', 'status'  => '1'),
                array('parent_id' => 10,'action'=>NULL,'name'  => 'Weekly Holiday', 'menu_url'  => 'weeklyHoliday.index', 'module_id'  => '3', 'status'  => '1'),
                array('parent_id' => 10,'action'=>NULL,'name'  => 'Leave Type', 'menu_url'  => 'leaveType.index', 'module_id'  => '3', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Leave Application', 'menu_url'  => null, 'module_id'  => '3', 'status'  => '1'),
                array('parent_id' => 15,'action'=>NULL,'name'  => 'Apply for Leave', 'menu_url'  => 'applyForLeave.index', 'module_id'  => '3', 'status'  => '1'),
                array('parent_id' => 15,'action'=>NULL,'name'  => 'Requested Application', 'menu_url'  => 'requestedApplication.index', 'module_id'  => '3', 'status'  => '1'),

                /**
                 *
                 * @attendance management
                 *
                 */

                array('parent_id' => 0,'action'=>NULL,'name'  => 'Setup', 'menu_url'  => null, 'module_id'  => '4', 'status'  => '1'),
                array('parent_id' => 18,'action'=>NULL,'name'  => 'Manage Work Shift', 'menu_url'  => 'workShift.index', 'module_id'  => '4', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Report', 'menu_url'  => null, 'module_id'  => '4', 'status'  => '1'),
                array('parent_id' => 20,'action'=>NULL,'name'  => 'Daily Attendance', 'menu_url'  => 'dailyAttendance.dailyAttendance', 'module_id'  => '4', 'status'  => '1'),

                array('parent_id' => 0,'action'=>NULL,'name'  => 'Report', 'menu_url'  => null, 'module_id'  => '3', 'status'  => '1'),
                array('parent_id' => 22,'action'=>NULL,'name'  => 'Leave Report', 'menu_url'  => 'leaveReport.leaveReport', 'module_id'  => '3', 'status'  => '1'),
                array('parent_id' => 20,'action'=>NULL,'name'  => 'Monthly Attendance', 'menu_url'  => 'monthlyAttendance.monthlyAttendance', 'module_id'  => '4', 'status'  => '1'),

                /**
                 *
                 * @Payroll management
                 *
                 */

                array('parent_id' => 0,'action'=>NULL,'name'  => 'Setup', 'menu_url'  => null, 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 25,'action'=>NULL,'name'  => 'Tax Rule Setup', 'menu_url'  => 'taxSetup.index', 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Allowance', 'menu_url'  => 'allowance.index', 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Deduction', 'menu_url'  => 'deduction.index', 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Monthly Pay Grade', 'menu_url'  => 'payGrade.index', 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Hourly Pay Grade', 'menu_url'  => 'hourlyWages.index', 'module_id'  => '5', 'status'  => '1'),

                array('parent_id' => 0,'action'=>NULL,'name'  => 'Generate Salary Sheet', 'menu_url'  => 'generateSalarySheet.index', 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 25,'action'=>NULL,'name'  => 'Late Configration', 'menu_url'  => 'salaryDeductionRule.index', 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Report', 'menu_url'  => null, 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 33,'action'=>NULL,'name'  => 'Payment History', 'menu_url'  => 'paymentHistory.paymentHistory', 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 33,'action'=>NULL,'name'  => 'My Payroll', 'menu_url'  => 'myPayroll.myPayroll', 'module_id'  => '5', 'status'  => '1'),

                /**
                 *
                 * @Performance management
                 *
                 */

                array('parent_id' => 0,'action'=>NULL,'name'  => 'Performance Category', 'menu_url'  => 'performanceCategory.index', 'module_id'  => '6', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Performance Criteria', 'menu_url'  => 'performanceCriteria.index', 'module_id'  => '6', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Employee Performance', 'menu_url'  => 'employeePerformance.index', 'module_id'  => '6', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Report', 'menu_url'  => null, 'module_id'  => '6', 'status'  => '1'),
                array('parent_id' => 39,'action'=>NULL,'name'  => 'Summary Report', 'menu_url'  => 'performanceSummaryReport.performanceSummaryReport', 'module_id'  => '6', 'status'  => '1'),


                /**
                 *
                 * @Recruitment
                 *
                 */

                array('parent_id' => 0,'action'=>NULL,'name'  => 'Job Post', 'menu_url'  => 'jobPost.index', 'module_id'  => '7', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Job Candidate', 'menu_url'  => 'jobCandidate.index', 'module_id'  => '7', 'status'  => '1'),



                /**
                 *
                 * @leave and attendance management
                 *
                 */

                array('parent_id' => 20,'action'=>NULL,'name'  => 'My Attendance Report', 'menu_url'  => 'myAttendanceReport.myAttendanceReport', 'module_id'  => '4', 'status'  => '1'),
                array('parent_id' => 10,'action'=>NULL,'name'  => 'Earn Leave Configure', 'menu_url'  => 'earnLeaveConfigure.index', 'module_id'  => '3', 'status'  => '1'),

                /**
                 *
                 * @Training
                 *
                 */
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Training Type', 'menu_url'  => 'trainingType.index','module_id'  => '8', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Training List', 'menu_url'  => 'trainingInfo.index','module_id'  => '8', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Training Report', 'menu_url'  => 'employeeTrainingReport.employeeTrainingReport','module_id'  => '8', 'status'  => '1'),


                /**
                 *
                 * @Award And Notice Board
                 *
                 */
                  array('parent_id' => 0,'action'=>NULL,'name'  => 'Award', 'menu_url'  => 'award.index','module_id'  => '9', 'status'  => '1'),
                  array('parent_id' => 0,'action'=>NULL,'name'  => 'Notice', 'menu_url'  => 'notice.index','module_id'  => '10', 'status'  => '1'),
                /**
                 *
                 * @Settings
                 *
                 */
                 array('parent_id' => 0,'action'=>NULL,'name'  => 'Settings', 'menu_url'  => 'generalSettings.index','module_id'  => '11', 'status'  => '1'),
                 array('parent_id' => 0,'action'=>NULL,'name'  => 'Manual Attendance', 'menu_url'  => 'manualAttendance.manualAttendance', 'module_id'  => '4', 'status'  => '1'),
                 array('parent_id' => 22,'action'=>NULL,'name'  => 'Summary Report', 'menu_url'  => 'summaryReport.summaryReport', 'module_id'  => '3', 'status'  => '1'),
                 array('parent_id' => 22,'action'=>NULL,'name'  => 'My Leave Report', 'menu_url'  => 'myLeaveReport.myLeaveReport', 'module_id'  => '3', 'status'  => '1'),

                 array('parent_id' => 0,'action'=>NULL,'name'  => 'Warning', 'menu_url'  => 'warning.index', 'module_id'  => '2', 'status'  => '1'),
                 array('parent_id' => 0,'action'=>NULL,'name'  => 'Termination', 'menu_url'  => 'termination.index', 'module_id'  => '2', 'status'  => '1'),
                 array('parent_id' => 0,'action'=>NULL,'name'  => 'Promotion', 'menu_url'  => 'promotion.index', 'module_id'  => '2', 'status'  => '1'),

                /**
                 *
                 * @attendance
                 *
                 */
                array('parent_id' => 20,'action'=>NULL,'name'  => 'Summary Report', 'menu_url'  => 'attendanceSummaryReport.attendanceSummaryReport', 'module_id'  => '4', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Manage Work Hour', 'menu_url'  => null, 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 58,'action'=>NULL,'name'  => 'Approve Work Hour', 'menu_url'  => 'workHourApproval.create', 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 0,'action'=>NULL,'name'  => 'Employee Permanent', 'menu_url'  => 'permanent.index', 'module_id'  => '2', 'status'  => '1'),

                array('parent_id' => 0,'action'=>NULL,'name'  => 'Manage Bonus', 'menu_url'  => null, 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 61,'action'=>NULL,'name'  => 'Bonus Setting', 'menu_url'  => 'bonusSetting.index', 'module_id'  => '5', 'status'  => '1'),
                array('parent_id' => 61,'action'=>NULL,'name'  => 'Generate Bonus', 'menu_url'  => 'generateBonus.index', 'module_id'  => '5', 'status'  => '1'),
            )
        );

    }
}
