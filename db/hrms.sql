-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2020 at 07:49 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrms`
--

DELIMITER $$
--
-- Procedures
--
CREATE  PROCEDURE `SP_calculateEmployeeLeaveBalance` (IN `employeeId` INT(10), IN `leaveTypeId` INT(10))  BEGIN  

          SELECT SUM(number_of_day) AS totalNumberOfDays FROM leave_application WHERE employee_id=employeeId AND leave_type_id=leaveTypeId and status = 2

          AND (approve_date  BETWEEN DATE_FORMAT(NOW(),'%Y-01-01') AND DATE_FORMAT(NOW(),'%Y-12-31'));

         END$$

CREATE  PROCEDURE `SP_DailyAttendance` (IN `input_date` DATE)  BEGIN 

 

select employee.employee_id,employee.photo,CONCAT(COALESCE(employee.first_name,''),' ',COALESCE(employee.last_name,'')) AS fullName,department_name,

                        view_employee_in_out_data.employee_attendance_id,view_employee_in_out_data.finger_print_id,view_employee_in_out_data.date,view_employee_in_out_data.working_time,

                        DATE_FORMAT(view_employee_in_out_data.in_time,'%h:%i %p') AS in_time,DATE_FORMAT(view_employee_in_out_data.out_time,'%h:%i %p') AS out_time, 

		TIME_FORMAT( work_shift.late_count_time, '%H:%i:%s' ) as lateCountTime,

	(SELECT CASE WHEN DATE_FORMAT(MIN(view_employee_in_out_data.in_time),'%H:%i:00')  > lateCountTime

            THEN 'Yes' 

            ELSE 'No' END) AS  ifLate,

 

            (SELECT CASE WHEN TIMEDIFF((DATE_FORMAT(MIN(view_employee_in_out_data.in_time),'%H:%i:%s')),work_shift.late_count_time)  > '0'

            THEN TIMEDIFF((DATE_FORMAT(MIN(view_employee_in_out_data.in_time),'%H:%i:%s')),work_shift.late_count_time) 

            ELSE '00:00:00' END) AS  totalLateTime,

             TIMEDIFF((DATE_FORMAT(work_shift.`end_time`,'%H:%i:%s')),work_shift.`start_time`) AS workingHour

                        from employee

                        inner join view_employee_in_out_data on view_employee_in_out_data.finger_print_id = employee.finger_id

                        inner join department on department.department_id = employee.department_id

JOIN work_shift on work_shift.work_shift_id = employee.work_shift_id

                        where `status`=1 AND `date`=input_date GROUP BY view_employee_in_out_data.finger_print_id ORDER BY employee_attendance_id DESC;

   



 

 END$$

CREATE  PROCEDURE `SP_getEmployeeInfo` (IN `employeeId` INT(10))  BEGIN

	       SELECT employee.*,user.`user_name` FROM employee 

            INNER JOIN `user` ON `user`.`user_id` = employee.`user_id`

            WHERE employee_id = employeeId;

        END$$

CREATE  PROCEDURE `SP_getHoliday` (IN `fromDate` DATE, IN `toDate` DATE)  BEGIN 

 

SELECT from_date,to_date FROM holiday_details WHERE from_date >= fromDate AND to_date <=toDate;

   



 

 END$$

CREATE  PROCEDURE `SP_getWeeklyHoliday` ()  BEGIN

	        select day_name from  weekly_holiday where status=1;

        END$$

CREATE  PROCEDURE `SP_monthlyAttendance` (IN `employeeId` INT(10), IN `from_date` DATE, IN `to_date` DATE)  BEGIN 

 

select employee.employee_id,CONCAT(COALESCE(employee.first_name,''),' ',COALESCE(employee.last_name,'')) AS fullName,department_name,

                        view_employee_in_out_data.finger_print_id,view_employee_in_out_data.date,view_employee_in_out_data.working_time,

                        DATE_FORMAT(view_employee_in_out_data.in_time,'%h:%i %p') AS in_time,DATE_FORMAT(view_employee_in_out_data.out_time,'%h:%i %p') AS out_time, 

		TIME_FORMAT( work_shift.late_count_time, '%H:%i:%s' ) as lateCountTime,

	(SELECT CASE WHEN DATE_FORMAT(MIN(view_employee_in_out_data.in_time),'%H:%i:00')  > lateCountTime

            THEN 'Yes' 

            ELSE 'No' END) AS  ifLate,

 

            (SELECT CASE WHEN TIMEDIFF((DATE_FORMAT(MIN(view_employee_in_out_data.in_time),'%H:%i:%s')),work_shift.late_count_time)  > '0'

            THEN TIMEDIFF((DATE_FORMAT(MIN(view_employee_in_out_data.in_time),'%H:%i:%s')),work_shift.late_count_time) 

            ELSE '00:00:00' END) AS  totalLateTime,

             TIMEDIFF((DATE_FORMAT(work_shift.`end_time`,'%H:%i:%s')),work_shift.`start_time`) AS workingHour

                        from employee

                        inner join view_employee_in_out_data on view_employee_in_out_data.finger_print_id = employee.finger_id

                        inner join department on department.department_id = employee.department_id

JOIN work_shift on work_shift.work_shift_id = employee.work_shift_id

                        where `status`=1 

                       AND `date` between from_date and to_date and employee_id=employeeId

                        GROUP BY view_employee_in_out_data.date,view_employee_in_out_data.`finger_print_id`;

   



 

 END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `allowance`
--

CREATE TABLE `allowance` (
  `allowance_id` int(10) UNSIGNED NOT NULL,
  `allowance_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allowance_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage_of_basic` int(11) NOT NULL,
  `limit_per_month` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allowance`
--

INSERT INTO `allowance` (`allowance_id`, `allowance_name`, `allowance_type`, `percentage_of_basic`, `limit_per_month`, `created_at`, `updated_at`) VALUES
(1, 'House Rent', 'Percentage', 50, 25000, '2017-12-26 09:07:43', '2017-12-26 09:07:43'),
(2, 'Convince', 'Fixed', 0, 2500, '2017-12-26 09:08:48', '2017-12-26 09:08:48'),
(3, 'Medical Allowance', 'Percentage', 10, 10000, '2017-12-26 09:10:38', '2017-12-26 09:10:38');

-- --------------------------------------------------------

--
-- Table structure for table `bonus_setting`
--

CREATE TABLE `bonus_setting` (
  `bonus_setting_id` int(10) UNSIGNED NOT NULL,
  `festival_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage_of_bonus` int(11) NOT NULL,
  `bonus_type` enum('Gross','Basic') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bonus_setting`
--

INSERT INTO `bonus_setting` (`bonus_setting_id`, `festival_name`, `percentage_of_bonus`, `bonus_type`, `created_at`, `updated_at`) VALUES
(3, 'Eid ul Fitr', 100, 'Basic', '2018-01-14 08:45:00', '2018-01-14 08:45:00'),
(4, 'Eid ul adhz', 100, 'Basic', '2018-01-14 08:45:19', '2018-01-14 08:45:19');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(10) UNSIGNED NOT NULL,
  `branch_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `created_at`, `updated_at`) VALUES
(2, 'Dhaka Branch', '2017-12-19 05:10:19', '2017-12-19 05:10:19'),
(4, 'Ashulia Branch', '2018-01-03 07:22:10', '2018-12-05 05:13:21');

-- --------------------------------------------------------

--
-- Table structure for table `company_address_settings`
--

CREATE TABLE `company_address_settings` (
  `company_address_setting_id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_address_settings`
--

INSERT INTO `company_address_settings` (`company_address_setting_id`, `address`, `created_at`, `updated_at`) VALUES
(1, '<div><b>Royex Payroll</b><br>Limmex Automation,<br>Mukto Bangla Complex Dhaka-1216<br></div><div><a target=\"_blank\" rel=\"nofollow\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</a></div> <br>', '2017-12-26 10:39:05', '2020-01-16 17:21:41');

-- --------------------------------------------------------

--
-- Table structure for table `deduction`
--

CREATE TABLE `deduction` (
  `deduction_id` int(10) UNSIGNED NOT NULL,
  `deduction_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deduction_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percentage_of_basic` int(11) NOT NULL,
  `limit_per_month` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deduction`
--

INSERT INTO `deduction` (`deduction_id`, `deduction_name`, `deduction_type`, `percentage_of_basic`, `limit_per_month`, `created_at`, `updated_at`) VALUES
(1, 'Provident Fund', 'Percentage', 3, 0, '2017-12-26 09:15:56', '2018-01-03 10:40:26');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(10) UNSIGNED NOT NULL,
  `department_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `created_at`, `updated_at`) VALUES
(6, 'IT', '2017-12-20 06:46:19', '2017-12-20 06:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `designation_id` int(10) UNSIGNED NOT NULL,
  `designation_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`designation_id`, `designation_name`, `created_at`, `updated_at`) VALUES
(19, 'Sr Software Engineer', '2018-12-05 05:18:55', '2018-12-05 05:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `earn_leave_rule`
--

CREATE TABLE `earn_leave_rule` (
  `earn_leave_rule_id` int(10) UNSIGNED NOT NULL,
  `for_month` int(11) NOT NULL,
  `day_of_earn_leave` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `earn_leave_rule`
--

INSERT INTO `earn_leave_rule` (`earn_leave_rule_id`, `for_month`, `day_of_earn_leave`, `created_at`, `updated_at`) VALUES
(1, 1, 1.50, '2017-12-19 05:10:24', '2019-02-06 07:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `finger_id` int(11) NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `designation_id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `work_shift_id` int(10) UNSIGNED NOT NULL,
  `pay_grade_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hourly_salaries_id` int(10) UNSIGNED DEFAULT 0,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_joining` date NOT NULL,
  `date_of_leaving` date DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `religion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contacts` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `permanent_status` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `user_id`, `finger_id`, `department_id`, `designation_id`, `branch_id`, `supervisor_id`, `work_shift_id`, `pay_grade_id`, `hourly_salaries_id`, `email`, `first_name`, `last_name`, `date_of_birth`, `date_of_joining`, `date_of_leaving`, `gender`, `religion`, `marital_status`, `photo`, `address`, `emergency_contacts`, `phone`, `status`, `permanent_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 2, 4, 6, 19, 2, NULL, 1, 1, NULL, 'skt@ex.com', 'Shakhawat', 'Sabbir', '1994-11-13', '2017-01-01', '2019-08-30', 'Male', 'Islam', 'Unmarried', '896fd2c27dcc2d95b7875db6d82b2538.png', NULL, NULL, 1832944654, 1, 1, 2, 2, '2017-12-20 06:24:19', '2019-09-12 16:23:09'),
(34, 34, 12, 6, 19, 2, 2, 1, 1, NULL, '94shakha.18@gmail.com', 'shakhawat', 'hossain', '1993-07-21', '2020-01-29', NULL, 'Male', 'Islam', 'Unmarried', NULL, NULL, NULL, 1832944211, 1, 0, 2, 2, '2020-01-10 03:07:27', '2020-01-10 03:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendance`
--

CREATE TABLE `employee_attendance` (
  `employee_attendance_id` int(10) UNSIGNED NOT NULL,
  `finger_print_id` int(11) NOT NULL,
  `in_out_time` datetime NOT NULL,
  `check_type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_code` bigint(20) DEFAULT NULL,
  `sensor_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Memoinfo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `WorkCode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sn` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UserExtFmt` int(11) DEFAULT NULL,
  `mechine_sl` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendance_approve`
--

CREATE TABLE `employee_attendance_approve` (
  `employee_attendance_approve_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `finger_print_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `in_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `out_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `working_hour` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approve_working_hour` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_award`
--

CREATE TABLE `employee_award` (
  `employee_award_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `award_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gift_item` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_award`
--

INSERT INTO `employee_award` (`employee_award_id`, `employee_id`, `award_name`, `gift_item`, `month`, `created_at`, `updated_at`) VALUES
(1, 2, 'Employee of the Year', 'no', '2020-01', '2020-01-12 17:54:59', '2020-01-12 17:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `employee_bonus`
--

CREATE TABLE `employee_bonus` (
  `employee_bonus_id` int(10) UNSIGNED NOT NULL,
  `bonus_setting_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `month` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_salary` int(11) NOT NULL,
  `basic_salary` int(11) NOT NULL,
  `bonus_amount` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_education_qualification`
--

CREATE TABLE `employee_education_qualification` (
  `employee_education_qualification_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `institute` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `board_university` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cgpa` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passing_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_experience`
--

CREATE TABLE `employee_experience` (
  `employee_experience_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `organization_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `skill` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsibility` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_performance`
--

CREATE TABLE `employee_performance` (
  `employee_performance_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `month` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_performance_details`
--

CREATE TABLE `employee_performance_details` (
  `employee_performance_details_id` int(10) UNSIGNED NOT NULL,
  `employee_performance_id` int(10) UNSIGNED NOT NULL,
  `performance_criteria_id` int(10) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `holiday_id` int(10) UNSIGNED NOT NULL,
  `holiday_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`holiday_id`, `holiday_name`, `created_at`, `updated_at`) VALUES
(3, 'Christmas Day', '2018-12-17 09:09:59', '2018-12-17 09:09:59'),
(17, 'Victory Day', '2020-01-16 17:50:29', '2020-01-16 17:50:29'),
(18, 'National Day', '2020-01-16 17:50:46', '2020-01-16 17:50:46');

-- --------------------------------------------------------

--
-- Table structure for table `holiday_details`
--

CREATE TABLE `holiday_details` (
  `holiday_details_id` int(10) UNSIGNED NOT NULL,
  `holiday_id` int(10) UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holiday_details`
--

INSERT INTO `holiday_details` (`holiday_details_id`, `holiday_id`, `from_date`, `to_date`, `comment`, `created_at`, `updated_at`) VALUES
(1, 18, '2020-02-07', '2020-02-08', NULL, '2020-01-16 17:51:16', '2020-01-16 17:51:16');

-- --------------------------------------------------------

--
-- Table structure for table `hourly_salaries`
--

CREATE TABLE `hourly_salaries` (
  `hourly_salaries_id` int(10) UNSIGNED NOT NULL,
  `hourly_grade` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hourly_rate` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hourly_salaries`
--

INSERT INTO `hourly_salaries` (`hourly_salaries_id`, `hourly_grade`, `hourly_rate`, `created_at`, `updated_at`) VALUES
(1, 'H-A', 1000, '2018-01-08 04:27:51', '2018-01-08 04:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `interview`
--

CREATE TABLE `interview` (
  `interview_id` int(10) UNSIGNED NOT NULL,
  `job_applicant_id` int(10) UNSIGNED NOT NULL,
  `interview_date` date NOT NULL,
  `interview_time` time NOT NULL,
  `interview_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `job_id` int(10) UNSIGNED NOT NULL,
  `job_title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_end_date` date NOT NULL,
  `publish_date` date NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_applicant`
--

CREATE TABLE `job_applicant` (
  `job_applicant_id` int(10) UNSIGNED NOT NULL,
  `job_id` int(10) UNSIGNED NOT NULL,
  `applicant_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `cover_letter` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attached_resume` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_application`
--

CREATE TABLE `leave_application` (
  `leave_application_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `application_from_date` date NOT NULL,
  `application_to_date` date NOT NULL,
  `application_date` date NOT NULL,
  `number_of_day` int(11) NOT NULL,
  `approve_date` date DEFAULT NULL,
  `reject_date` date DEFAULT NULL,
  `approve_by` int(11) DEFAULT NULL,
  `reject_by` int(11) DEFAULT NULL,
  `purpose` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'status(1,2,3) = Pending,Approve,Reject',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `leave_type_id` int(10) UNSIGNED NOT NULL,
  `leave_type_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_of_day` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`leave_type_id`, `leave_type_name`, `num_of_day`, `created_at`, `updated_at`) VALUES
(1, 'Earn Leave', 0, '2018-01-10 10:25:01', '2018-01-10 10:25:01'),
(2, 'Casual Leave', 22, '2018-01-10 10:25:01', '2018-01-10 10:25:01'),
(3, 'Sick Leave	', 20, '2018-01-10 10:25:01', '2018-01-10 10:25:01');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `action` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `action`, `name`, `menu_url`, `module_id`, `status`) VALUES
(1, 0, NULL, 'User', 'user.index', 1, 2),
(2, 0, NULL, 'Manage Role', NULL, 1, 1),
(3, 2, NULL, 'Add Role', 'userRole.index', 1, 1),
(4, 2, NULL, 'Add Role Permission', 'rolePermission.index', 1, 1),
(5, 0, NULL, 'Change Password', 'changePassword.index', 1, 1),
(6, 0, NULL, 'Department', 'department.index', 2, 1),
(7, 0, NULL, 'Designation', 'designation.index', 2, 1),
(8, 0, NULL, 'Branch', 'branch.index', 2, 1),
(9, 0, NULL, 'Manage Employee', 'employee.index', 2, 1),
(10, 0, NULL, 'Setup', NULL, 3, 1),
(11, 10, NULL, 'Manage Holiday', 'holiday.index', 3, 1),
(12, 10, NULL, 'Public Holiday', 'publicHoliday.index', 3, 1),
(13, 10, NULL, 'Weekly Holiday', 'weeklyHoliday.index', 3, 1),
(14, 10, NULL, 'Leave Type', 'leaveType.index', 3, 1),
(15, 0, NULL, 'Leave Application', NULL, 3, 1),
(16, 15, NULL, 'Apply for Leave', 'applyForLeave.index', 3, 1),
(17, 15, NULL, 'Requested Application', 'requestedApplication.index', 3, 1),
(18, 0, NULL, 'Setup', NULL, 4, 1),
(19, 18, NULL, 'Manage Work Shift', 'workShift.index', 4, 1),
(20, 0, NULL, 'Report', NULL, 4, 1),
(21, 20, NULL, 'Daily Attendance', 'dailyAttendance.dailyAttendance', 4, 1),
(22, 0, NULL, 'Report', NULL, 3, 1),
(23, 22, NULL, 'Leave Report', 'leaveReport.leaveReport', 3, 1),
(24, 20, NULL, 'Monthly Attendance', 'monthlyAttendance.monthlyAttendance', 4, 1),
(25, 0, NULL, 'Setup', NULL, 5, 1),
(26, 25, NULL, 'Tax Rule Setup', 'taxSetup.index', 5, 1),
(27, 0, NULL, 'Allowance', 'allowance.index', 5, 1),
(28, 0, NULL, 'Deduction', 'deduction.index', 5, 1),
(29, 0, NULL, 'Monthly Pay Grade', 'payGrade.index', 5, 1),
(30, 0, NULL, 'Hourly Pay Grade', 'hourlyWages.index', 5, 1),
(31, 0, NULL, 'Generate Salary Sheet', 'generateSalarySheet.index', 5, 1),
(32, 25, NULL, 'Late Configration', 'salaryDeductionRule.index', 5, 1),
(33, 0, NULL, 'Report', NULL, 5, 1),
(34, 33, NULL, 'Payment History', 'paymentHistory.paymentHistory', 5, 1),
(35, 33, NULL, 'My Payroll', 'myPayroll.myPayroll', 5, 1),
(36, 0, NULL, 'Performance Category', 'performanceCategory.index', 6, 1),
(37, 0, NULL, 'Performance Criteria', 'performanceCriteria.index', 6, 1),
(38, 0, NULL, 'Employee Performance', 'employeePerformance.index', 6, 1),
(39, 0, NULL, 'Report', NULL, 6, 1),
(40, 39, NULL, 'Summary Report', 'performanceSummaryReport.performanceSummaryReport', 6, 1),
(41, 0, NULL, 'Job Post', 'jobPost.index', 7, 1),
(42, 0, NULL, 'Job Candidate', 'jobCandidate.index', 7, 1),
(43, 20, NULL, 'My Attendance Report', 'myAttendanceReport.myAttendanceReport', 4, 1),
(44, 10, NULL, 'Earn Leave Configure', 'earnLeaveConfigure.index', 3, 1),
(45, 0, NULL, 'Training Type', 'trainingType.index', 8, 1),
(46, 0, NULL, 'Training List', 'trainingInfo.index', 8, 1),
(47, 0, NULL, 'Training Report', 'employeeTrainingReport.employeeTrainingReport', 8, 1),
(48, 0, NULL, 'Award', 'award.index', 9, 1),
(49, 0, NULL, 'Notice', 'notice.index', 10, 1),
(50, 0, NULL, 'Settings', 'generalSettings.index', 11, 1),
(51, 0, NULL, 'Manual Attendance', 'manualAttendance.manualAttendance', 4, 1),
(52, 22, NULL, 'Summary Report', 'summaryReport.summaryReport', 3, 1),
(53, 22, NULL, 'My Leave Report', 'myLeaveReport.myLeaveReport', 3, 1),
(54, 0, NULL, 'Warning', 'warning.index', 2, 1),
(55, 0, NULL, 'Termination', 'termination.index', 2, 1),
(56, 0, NULL, 'Promotion', 'promotion.index', 2, 1),
(57, 20, NULL, 'Summary Report', 'attendanceSummaryReport.attendanceSummaryReport', 4, 1),
(58, 0, NULL, 'Manage Work Hour', NULL, 5, 1),
(59, 58, NULL, 'Approve Work Hour', 'workHourApproval.create', 5, 1),
(60, 0, NULL, 'Employee Permanent', 'permanent.index', 2, 1),
(61, 0, NULL, 'Manage Bonus', NULL, 5, 1),
(62, 61, NULL, 'Bonus Setting', 'bonusSetting.index', 5, 1),
(63, 61, NULL, 'Generate Bonus', 'generateBonus.index', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_permission`
--

CREATE TABLE `menu_permission` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_permission`
--

INSERT INTO `menu_permission` (`id`, `role_id`, `menu_id`) VALUES
(230, 1, 2),
(231, 1, 3),
(232, 1, 4),
(233, 1, 5),
(234, 1, 6),
(235, 1, 7),
(236, 1, 8),
(237, 1, 9),
(238, 1, 54),
(239, 1, 55),
(240, 1, 56),
(241, 1, 60),
(242, 1, 10),
(243, 1, 11),
(244, 1, 12),
(245, 1, 13),
(246, 1, 14),
(247, 1, 15),
(248, 1, 16),
(249, 1, 17),
(250, 1, 22),
(251, 1, 23),
(252, 1, 44),
(253, 1, 52),
(254, 1, 53),
(255, 1, 18),
(256, 1, 19),
(257, 1, 20),
(258, 1, 21),
(259, 1, 24),
(260, 1, 43),
(261, 1, 51),
(262, 1, 57),
(263, 1, 25),
(264, 1, 26),
(265, 1, 27),
(266, 1, 28),
(267, 1, 29),
(268, 1, 30),
(269, 1, 31),
(270, 1, 32),
(271, 1, 33),
(272, 1, 34),
(273, 1, 35),
(274, 1, 58),
(275, 1, 59),
(276, 1, 61),
(277, 1, 62),
(278, 1, 63),
(279, 1, 36),
(280, 1, 37),
(281, 1, 38),
(282, 1, 39),
(283, 1, 40),
(284, 1, 41),
(285, 1, 42),
(286, 1, 45),
(287, 1, 46),
(288, 1, 47),
(289, 1, 48),
(290, 1, 49),
(291, 1, 50),
(868, 9, 5),
(869, 9, 15),
(870, 9, 16),
(871, 9, 17),
(872, 9, 22),
(873, 9, 53),
(874, 9, 20),
(875, 9, 43),
(876, 9, 33),
(877, 9, 35);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_09_09_085518_MenuPermissionMigration', 1),
(2, '2017_09_10_080607_create_menus_table', 1),
(3, '2017_09_13_095759_create_roles_table', 1),
(4, '2017_09_19_030632_create_departments_table', 1),
(5, '2017_09_19_043154_create_designations_table', 1),
(6, '2017_09_19_053209_create_employees_table', 1),
(7, '2017_09_19_060623_create_employee_experiences_table', 1),
(8, '2017_09_19_062907_create_employee_education_qualifications_table', 1),
(9, '2017_09_1_000000_create_users_table', 1),
(10, '2017_09_27_033248_create_branches_table', 1),
(11, '2017_09_2_081056_create_modules_table', 1),
(12, '2017_10_02_042807_create_holidays_table', 1),
(13, '2017_10_04_035502_create_holiday_details_table', 1),
(14, '2017_10_04_050224_create_weekly_holidays_table', 1),
(15, '2017_10_04_050517_create_leave_types_table', 1),
(16, '2017_10_04_093455_create_leave_applications_table', 1),
(17, '2017_10_05_094341_create_SP_weekly_holiday_store_procedure', 1),
(18, '2017_10_05_095235_create_SP_get_holiday_store_procedure', 1),
(19, '2017_10_05_095429_create_SP_get_employee_leave_balance_store_procedure', 1),
(20, '2017_10_09_043228_create_work_shifts_table', 1),
(21, '2017_10_09_074500_create_employee_attendances_table', 1),
(22, '2017_10_09_095518_create_view_get_employee_in_out_data', 1),
(25, '2017_10_11_084031_create_allownce_table', 1),
(26, '2017_10_11_084043_create_deduction_table', 1),
(27, '2017_10_23_051619_create_pay_grades_table', 1),
(28, '2017_10_26_064948_create_tax_rules_table', 1),
(29, '2017_10_29_075627_create_pay_grade_to_allowances_table', 1),
(30, '2017_10_29_075706_create_pay_grade_to_deductions_table', 1),
(31, '2017_10_30_065329_create_SP_get_employee_info_store_procedure', 1),
(32, '2017_11_01_045130_create_salary_deduction_for_late_attendances_table', 1),
(33, '2017_11_02_051338_create_salary_details_table', 1),
(34, '2017_11_02_053649_create_salary_details_to_allowances_table', 1),
(35, '2017_11_02_054000_create_salary_details_to_deductions_table', 1),
(36, '2017_11_07_042136_create_performance_categories_table', 1),
(37, '2017_11_07_042334_create_performance_criterias_table', 1),
(38, '2017_11_08_035959_create_employee_performances_table', 1),
(39, '2017_11_08_040029_create_employee_performance_details_table', 1),
(40, '2017_11_14_061231_create_earn_leave_rules_table', 1),
(41, '2017_11_14_092829_create_company_address_settings_table', 1),
(42, '2017_11_15_090514_create_employee_awards_table', 1),
(43, '2017_11_15_105135_create_notices_table', 1),
(44, '2017_11_23_102429_create_print_head_settings_table', 1),
(45, '2017_12_03_112226_create_training_types_table', 1),
(46, '2017_12_03_112805_create_training_infos_table', 1),
(47, '2017_12_04_114921_create_warnings_table', 1),
(48, '2017_12_04_140839_create_terminations_table', 1),
(49, '2017_12_05_154824_create_promotions_table', 1),
(50, '2017_12_10_122540_create_hourly_salaries_table', 1),
(51, '2017_12_13_144211_create_jobs_table', 1),
(52, '2017_12_13_144259_create_job_applicants_table', 1),
(53, '2017_12_13_144320_create_interviews_table', 1),
(54, '2030_09_17_062133_KeyContstraintsMigration', 1),
(55, '2017_12_31_222850_create_salary_details_to_leaves_table', 2),
(56, '2017_10_11_051354_create_SP_daily_attendance_store_procedure', 3),
(57, '2017_10_11_083952_create_SP_monthly_attendance_store_procedure', 3),
(62, '2018_01_08_144502_create_employee_attendance_approves_table', 4),
(67, '2018_01_10_150238_create_bonus_settings_table', 5),
(68, '2018_01_10_161034_create_employee_bonuses_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_class` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `icon_class`) VALUES
(1, 'Administration', 'mdi mdi-key-plus'),
(2, 'Employee Management', 'mdi mdi-account-multiple-plus'),
(3, 'Leave Management', 'mdi mdi-exit-to-app'),
(4, 'Attendance', 'mdi mdi-calendar-clock'),
(5, 'Payroll', 'mdi mdi-dolby'),
(6, 'Performance', 'mdi mdi-chart-line'),
(7, 'Recruitment', 'mdi mdi-worker'),
(8, 'Training', 'mdi mdi-certificate'),
(9, 'Award', 'mdi mdi-trophy-variant'),
(10, 'Notice Board', 'mdi mdi-flag-checkered'),
(11, 'Settings', 'mdi mdi-wrench');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `notice_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `publish_date` date NOT NULL,
  `attach_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_grade`
--

CREATE TABLE `pay_grade` (
  `pay_grade_id` int(10) UNSIGNED NOT NULL,
  `pay_grade_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_salary` int(11) NOT NULL,
  `percentage_of_basic` int(11) NOT NULL,
  `basic_salary` int(11) NOT NULL,
  `overtime_rate` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pay_grade`
--

INSERT INTO `pay_grade` (`pay_grade_id`, `pay_grade_name`, `gross_salary`, `percentage_of_basic`, `basic_salary`, `overtime_rate`, `created_at`, `updated_at`) VALUES
(1, 'A', 100000, 50, 50000, 500, '2018-01-08 05:03:38', '2018-01-08 05:03:38'),
(2, 'B', 80000, 50, 40000, 500, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pay_grade_to_allowance`
--

CREATE TABLE `pay_grade_to_allowance` (
  `pay_grade_to_allowance_id` int(10) UNSIGNED NOT NULL,
  `pay_grade_id` int(11) NOT NULL,
  `allowance_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pay_grade_to_allowance`
--

INSERT INTO `pay_grade_to_allowance` (`pay_grade_to_allowance_id`, `pay_grade_id`, `allowance_id`, `created_at`, `updated_at`) VALUES
(37, 1, 1, '2018-01-04 06:04:01', '2018-01-04 06:04:01'),
(38, 1, 2, '2018-01-04 06:04:01', '2018-01-04 06:04:01'),
(39, 1, 3, '2018-01-04 06:04:01', '2018-01-04 06:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `pay_grade_to_deduction`
--

CREATE TABLE `pay_grade_to_deduction` (
  `pay_grade_to_deduction_id` int(10) UNSIGNED NOT NULL,
  `pay_grade_id` int(11) NOT NULL,
  `deduction_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pay_grade_to_deduction`
--

INSERT INTO `pay_grade_to_deduction` (`pay_grade_to_deduction_id`, `pay_grade_id`, `deduction_id`, `created_at`, `updated_at`) VALUES
(12, 1, 1, '2018-01-04 06:04:01', '2018-01-04 06:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `performance_category`
--

CREATE TABLE `performance_category` (
  `performance_category_id` int(10) UNSIGNED NOT NULL,
  `performance_category_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performance_criteria`
--

CREATE TABLE `performance_criteria` (
  `performance_criteria_id` int(10) UNSIGNED NOT NULL,
  `performance_category_id` int(10) UNSIGNED NOT NULL,
  `performance_criteria_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `print_head_settings`
--

CREATE TABLE `print_head_settings` (
  `print_head_setting_id` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `print_head_settings`
--

INSERT INTO `print_head_settings` (`print_head_setting_id`, `description`, `created_at`, `updated_at`) VALUES
(1, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Royex Payroll</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Limmex Automation,<br>Muktobangla complex, Dhaka-1216<br>', '2018-01-01 05:07:22', '2020-01-16 17:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `promotion_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `current_department` int(10) UNSIGNED NOT NULL,
  `current_designation` int(10) UNSIGNED NOT NULL,
  `current_pay_grade` int(11) NOT NULL,
  `current_salary` int(11) NOT NULL,
  `promoted_pay_grade` int(10) UNSIGNED NOT NULL,
  `new_salary` int(11) NOT NULL,
  `promoted_department` int(10) UNSIGNED NOT NULL,
  `promoted_designation` int(10) UNSIGNED NOT NULL,
  `promotion_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', '2019-02-12 06:33:06', '2019-02-12 06:34:12'),
(9, 'Employee', '2020-01-10 03:04:18', '2020-01-10 03:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `salary_deduction_for_late_attendance`
--

CREATE TABLE `salary_deduction_for_late_attendance` (
  `salary_deduction_for_late_attendance_id` int(10) UNSIGNED NOT NULL,
  `for_days` int(11) NOT NULL,
  `day_of_salary_deduction` int(11) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `salary_deduction_for_late_attendance`
--

INSERT INTO `salary_deduction_for_late_attendance` (`salary_deduction_for_late_attendance_id`, `for_days`, `day_of_salary_deduction`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Active', '2018-01-10 10:25:00', '2018-01-10 10:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `salary_details`
--

CREATE TABLE `salary_details` (
  `salary_details_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `month_of_salary` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `basic_salary` int(11) NOT NULL DEFAULT 0,
  `total_allowance` int(11) NOT NULL DEFAULT 0,
  `total_deduction` int(11) NOT NULL DEFAULT 0,
  `total_late` int(11) NOT NULL DEFAULT 0,
  `total_late_amount` int(11) NOT NULL DEFAULT 0,
  `total_absence` int(11) NOT NULL DEFAULT 0,
  `total_absence_amount` int(11) NOT NULL DEFAULT 0,
  `overtime_rate` int(11) NOT NULL DEFAULT 0,
  `total_over_time_hour` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00:00',
  `total_overtime_amount` int(11) NOT NULL DEFAULT 0,
  `hourly_rate` int(11) NOT NULL DEFAULT 0,
  `total_present` int(11) NOT NULL DEFAULT 0,
  `total_leave` int(11) NOT NULL DEFAULT 0,
  `total_working_days` int(11) NOT NULL DEFAULT 0,
  `tax` int(11) NOT NULL DEFAULT 0,
  `gross_salary` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `per_day_salary` int(11) NOT NULL DEFAULT 0,
  `taxable_salary` int(11) NOT NULL DEFAULT 0,
  `net_salary` int(11) NOT NULL DEFAULT 0,
  `working_hour` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_details_to_allowance`
--

CREATE TABLE `salary_details_to_allowance` (
  `salary_details_to_allowance_id` int(10) UNSIGNED NOT NULL,
  `salary_details_id` int(11) NOT NULL,
  `allowance_id` int(11) NOT NULL,
  `amount_of_allowance` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_details_to_deduction`
--

CREATE TABLE `salary_details_to_deduction` (
  `salary_details_to_deduction_id` int(10) UNSIGNED NOT NULL,
  `salary_details_id` int(11) NOT NULL,
  `deduction_id` int(11) NOT NULL,
  `amount_of_deduction` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_details_to_leave`
--

CREATE TABLE `salary_details_to_leave` (
  `salary_details_to_leave_id` int(10) UNSIGNED NOT NULL,
  `salary_details_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `num_of_day` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rule`
--

CREATE TABLE `tax_rule` (
  `tax_rule_id` int(10) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `percentage_of_tax` int(11) NOT NULL,
  `amount_of_tax` int(11) NOT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_rule`
--

INSERT INTO `tax_rule` (`tax_rule_id`, `amount`, `percentage_of_tax`, `amount_of_tax`, `gender`, `created_at`, `updated_at`) VALUES
(1, 250000, 0, 0, 'Male', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(2, 400000, 10, 40000, 'Male', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(3, 500000, 15, 75000, 'Male', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(4, 600000, 20, 120000, 'Male', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(5, 3000000, 25, 750000, 'Male', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(6, 0, 30, 0, 'Male', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(7, 300000, 0, 0, 'Female', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(8, 400000, 10, 40000, 'Female', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(9, 500000, 15, 75000, 'Female', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(10, 600000, 20, 120000, 'Female', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(11, 3000000, 25, 750000, 'Female', '2018-01-10 10:25:00', '2018-01-10 10:25:00'),
(12, 0, 30, 0, 'Female', '2018-01-10 10:25:00', '2018-01-10 10:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `termination`
--

CREATE TABLE `termination` (
  `termination_id` int(10) UNSIGNED NOT NULL,
  `terminate_to` int(10) UNSIGNED NOT NULL,
  `terminate_by` int(10) UNSIGNED NOT NULL,
  `termination_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notice_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_info`
--

CREATE TABLE `training_info` (
  `training_info_id` int(10) UNSIGNED NOT NULL,
  `training_type_id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `certificate` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training_info`
--

INSERT INTO `training_info` (`training_info_id`, `training_type_id`, `employee_id`, `subject`, `start_date`, `end_date`, `description`, `certificate`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 'Web Development Seminar', '2020-01-16', '2020-01-18', ';pre', '', 2, 2, '2020-01-16 16:13:01', '2020-01-16 16:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `training_type`
--

CREATE TABLE `training_type` (
  `training_type_id` int(10) UNSIGNED NOT NULL,
  `training_type_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training_type`
--

INSERT INTO `training_type` (`training_type_id`, `training_type_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Career Development', 1, '2020-01-12 16:41:48', '2020-01-12 16:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role_id`, `user_name`, `password`, `status`, `remember_token`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 1, 'admin', '$2y$10$LUh6nTp.U5NB3XMl9KqrRu3n6N0RYeSf2hLOgcOSCWtg2Hi4js8Gq', 1, 'NcxWgEwlOejUmVe0snYm0fqf7kvVpc2Nuizs0tZbVYZmjrv1g3QRigdse7pb', 2, 2, '2017-12-20 06:24:19', '2020-01-13 08:46:56'),
(34, 9, 'employee', '$2y$10$RK8iZ2/rrTuz1LLuOZCYhuAKPHIvGHswrrBcVvDr1r664BYIT1y9G', 1, 'FbL822nydJjG8mNcOtPImXZhwVi8rdEzuUzIk0Pb8uQgTDzEJ9Gck2q6ne10', 2, 2, '2020-01-10 03:07:27', '2020-01-10 03:07:27');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_employee_in_out_data`
-- (See below for the actual view)
--
CREATE TABLE `view_employee_in_out_data` (
`employee_attendance_id` int(10) unsigned
,`finger_print_id` int(11)
,`in_time` datetime
,`out_time` varchar(19)
,`date` varchar(10)
,`working_time` time
);

-- --------------------------------------------------------

--
-- Table structure for table `warning`
--

CREATE TABLE `warning` (
  `warning_id` int(10) UNSIGNED NOT NULL,
  `warning_to` int(10) UNSIGNED NOT NULL,
  `warning_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warning_by` int(10) UNSIGNED NOT NULL,
  `warning_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weekly_holiday`
--

CREATE TABLE `weekly_holiday` (
  `week_holiday_id` int(10) UNSIGNED NOT NULL,
  `day_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weekly_holiday`
--

INSERT INTO `weekly_holiday` (`week_holiday_id`, `day_name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Friday', 1, '2017-12-28 06:14:33', '2017-12-28 06:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `work_shift`
--

CREATE TABLE `work_shift` (
  `work_shift_id` int(10) UNSIGNED NOT NULL,
  `shift_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `late_count_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_shift`
--

INSERT INTO `work_shift` (`work_shift_id`, `shift_name`, `start_time`, `end_time`, `late_count_time`, `created_at`, `updated_at`) VALUES
(1, 'Day', '10:00:00', '18:00:00', '10:15:00', '2018-01-08 05:03:38', '2018-12-05 06:17:02');

-- --------------------------------------------------------

--
-- Structure for view `view_employee_in_out_data`
--
DROP TABLE IF EXISTS `view_employee_in_out_data`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `view_employee_in_out_data`  AS  select `employee_attendance`.`employee_attendance_id` AS `employee_attendance_id`,`employee_attendance`.`finger_print_id` AS `finger_print_id`,min(`employee_attendance`.`in_out_time`) AS `in_time`,if(count(`employee_attendance`.`in_out_time`) > 1,max(`employee_attendance`.`in_out_time`),'') AS `out_time`,date_format(`employee_attendance`.`in_out_time`,'%Y-%m-%d') AS `date`,timediff(max(`employee_attendance`.`in_out_time`),min(`employee_attendance`.`in_out_time`)) AS `working_time` from `employee_attendance` group by date_format(`employee_attendance`.`in_out_time`,'%Y-%m-%d'),`employee_attendance`.`finger_print_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowance`
--
ALTER TABLE `allowance`
  ADD PRIMARY KEY (`allowance_id`);

--
-- Indexes for table `bonus_setting`
--
ALTER TABLE `bonus_setting`
  ADD PRIMARY KEY (`bonus_setting_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD UNIQUE KEY `branch_branch_name_unique` (`branch_name`);

--
-- Indexes for table `company_address_settings`
--
ALTER TABLE `company_address_settings`
  ADD PRIMARY KEY (`company_address_setting_id`);

--
-- Indexes for table `deduction`
--
ALTER TABLE `deduction`
  ADD PRIMARY KEY (`deduction_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `department_department_name_unique` (`department_name`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`designation_id`),
  ADD UNIQUE KEY `designation_designation_name_unique` (`designation_name`);

--
-- Indexes for table `earn_leave_rule`
--
ALTER TABLE `earn_leave_rule`
  ADD PRIMARY KEY (`earn_leave_rule_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `employee_finger_id_unique` (`finger_id`),
  ADD UNIQUE KEY `employee_email_unique` (`email`);

--
-- Indexes for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  ADD PRIMARY KEY (`employee_attendance_id`);

--
-- Indexes for table `employee_attendance_approve`
--
ALTER TABLE `employee_attendance_approve`
  ADD PRIMARY KEY (`employee_attendance_approve_id`);

--
-- Indexes for table `employee_award`
--
ALTER TABLE `employee_award`
  ADD PRIMARY KEY (`employee_award_id`);

--
-- Indexes for table `employee_bonus`
--
ALTER TABLE `employee_bonus`
  ADD PRIMARY KEY (`employee_bonus_id`);

--
-- Indexes for table `employee_education_qualification`
--
ALTER TABLE `employee_education_qualification`
  ADD PRIMARY KEY (`employee_education_qualification_id`);

--
-- Indexes for table `employee_experience`
--
ALTER TABLE `employee_experience`
  ADD PRIMARY KEY (`employee_experience_id`);

--
-- Indexes for table `employee_performance`
--
ALTER TABLE `employee_performance`
  ADD PRIMARY KEY (`employee_performance_id`);

--
-- Indexes for table `employee_performance_details`
--
ALTER TABLE `employee_performance_details`
  ADD PRIMARY KEY (`employee_performance_details_id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`holiday_id`),
  ADD UNIQUE KEY `holiday_holiday_name_unique` (`holiday_name`);

--
-- Indexes for table `holiday_details`
--
ALTER TABLE `holiday_details`
  ADD PRIMARY KEY (`holiday_details_id`);

--
-- Indexes for table `hourly_salaries`
--
ALTER TABLE `hourly_salaries`
  ADD PRIMARY KEY (`hourly_salaries_id`);

--
-- Indexes for table `interview`
--
ALTER TABLE `interview`
  ADD PRIMARY KEY (`interview_id`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `job_applicant`
--
ALTER TABLE `job_applicant`
  ADD PRIMARY KEY (`job_applicant_id`);

--
-- Indexes for table `leave_application`
--
ALTER TABLE `leave_application`
  ADD PRIMARY KEY (`leave_application_id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`leave_type_id`),
  ADD UNIQUE KEY `leave_type_leave_type_name_unique` (`leave_type_name`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_permission`
--
ALTER TABLE `menu_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `pay_grade`
--
ALTER TABLE `pay_grade`
  ADD PRIMARY KEY (`pay_grade_id`),
  ADD UNIQUE KEY `pay_grade_pay_grade_name_unique` (`pay_grade_name`);

--
-- Indexes for table `pay_grade_to_allowance`
--
ALTER TABLE `pay_grade_to_allowance`
  ADD PRIMARY KEY (`pay_grade_to_allowance_id`);

--
-- Indexes for table `pay_grade_to_deduction`
--
ALTER TABLE `pay_grade_to_deduction`
  ADD PRIMARY KEY (`pay_grade_to_deduction_id`);

--
-- Indexes for table `performance_category`
--
ALTER TABLE `performance_category`
  ADD PRIMARY KEY (`performance_category_id`),
  ADD UNIQUE KEY `performance_category_performance_category_name_unique` (`performance_category_name`);

--
-- Indexes for table `performance_criteria`
--
ALTER TABLE `performance_criteria`
  ADD PRIMARY KEY (`performance_criteria_id`);

--
-- Indexes for table `print_head_settings`
--
ALTER TABLE `print_head_settings`
  ADD PRIMARY KEY (`print_head_setting_id`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`promotion_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_role_name_unique` (`role_name`);

--
-- Indexes for table `salary_deduction_for_late_attendance`
--
ALTER TABLE `salary_deduction_for_late_attendance`
  ADD PRIMARY KEY (`salary_deduction_for_late_attendance_id`);

--
-- Indexes for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD PRIMARY KEY (`salary_details_id`);

--
-- Indexes for table `salary_details_to_allowance`
--
ALTER TABLE `salary_details_to_allowance`
  ADD PRIMARY KEY (`salary_details_to_allowance_id`);

--
-- Indexes for table `salary_details_to_deduction`
--
ALTER TABLE `salary_details_to_deduction`
  ADD PRIMARY KEY (`salary_details_to_deduction_id`);

--
-- Indexes for table `salary_details_to_leave`
--
ALTER TABLE `salary_details_to_leave`
  ADD PRIMARY KEY (`salary_details_to_leave_id`);

--
-- Indexes for table `tax_rule`
--
ALTER TABLE `tax_rule`
  ADD PRIMARY KEY (`tax_rule_id`);

--
-- Indexes for table `termination`
--
ALTER TABLE `termination`
  ADD PRIMARY KEY (`termination_id`);

--
-- Indexes for table `training_info`
--
ALTER TABLE `training_info`
  ADD PRIMARY KEY (`training_info_id`);

--
-- Indexes for table `training_type`
--
ALTER TABLE `training_type`
  ADD PRIMARY KEY (`training_type_id`),
  ADD UNIQUE KEY `training_type_training_type_name_unique` (`training_type_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_user_name_unique` (`user_name`);

--
-- Indexes for table `warning`
--
ALTER TABLE `warning`
  ADD PRIMARY KEY (`warning_id`);

--
-- Indexes for table `weekly_holiday`
--
ALTER TABLE `weekly_holiday`
  ADD PRIMARY KEY (`week_holiday_id`),
  ADD UNIQUE KEY `weekly_holiday_day_name_unique` (`day_name`);

--
-- Indexes for table `work_shift`
--
ALTER TABLE `work_shift`
  ADD PRIMARY KEY (`work_shift_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowance`
--
ALTER TABLE `allowance`
  MODIFY `allowance_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bonus_setting`
--
ALTER TABLE `bonus_setting`
  MODIFY `bonus_setting_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_address_settings`
--
ALTER TABLE `company_address_settings`
  MODIFY `company_address_setting_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deduction`
--
ALTER TABLE `deduction`
  MODIFY `deduction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `designation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `earn_leave_rule`
--
ALTER TABLE `earn_leave_rule`
  MODIFY `earn_leave_rule_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `employee_attendance`
--
ALTER TABLE `employee_attendance`
  MODIFY `employee_attendance_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_attendance_approve`
--
ALTER TABLE `employee_attendance_approve`
  MODIFY `employee_attendance_approve_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_award`
--
ALTER TABLE `employee_award`
  MODIFY `employee_award_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_bonus`
--
ALTER TABLE `employee_bonus`
  MODIFY `employee_bonus_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_education_qualification`
--
ALTER TABLE `employee_education_qualification`
  MODIFY `employee_education_qualification_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_experience`
--
ALTER TABLE `employee_experience`
  MODIFY `employee_experience_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_performance`
--
ALTER TABLE `employee_performance`
  MODIFY `employee_performance_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_performance_details`
--
ALTER TABLE `employee_performance_details`
  MODIFY `employee_performance_details_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holiday_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `holiday_details`
--
ALTER TABLE `holiday_details`
  MODIFY `holiday_details_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hourly_salaries`
--
ALTER TABLE `hourly_salaries`
  MODIFY `hourly_salaries_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `interview`
--
ALTER TABLE `interview`
  MODIFY `interview_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `job_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_applicant`
--
ALTER TABLE `job_applicant`
  MODIFY `job_applicant_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_application`
--
ALTER TABLE `leave_application`
  MODIFY `leave_application_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_type`
--
ALTER TABLE `leave_type`
  MODIFY `leave_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `menu_permission`
--
ALTER TABLE `menu_permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=878;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `notice_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_grade`
--
ALTER TABLE `pay_grade`
  MODIFY `pay_grade_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pay_grade_to_allowance`
--
ALTER TABLE `pay_grade_to_allowance`
  MODIFY `pay_grade_to_allowance_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `pay_grade_to_deduction`
--
ALTER TABLE `pay_grade_to_deduction`
  MODIFY `pay_grade_to_deduction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `performance_category`
--
ALTER TABLE `performance_category`
  MODIFY `performance_category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performance_criteria`
--
ALTER TABLE `performance_criteria`
  MODIFY `performance_criteria_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `print_head_settings`
--
ALTER TABLE `print_head_settings`
  MODIFY `print_head_setting_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `promotion_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `salary_deduction_for_late_attendance`
--
ALTER TABLE `salary_deduction_for_late_attendance`
  MODIFY `salary_deduction_for_late_attendance_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salary_details`
--
ALTER TABLE `salary_details`
  MODIFY `salary_details_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_details_to_allowance`
--
ALTER TABLE `salary_details_to_allowance`
  MODIFY `salary_details_to_allowance_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_details_to_deduction`
--
ALTER TABLE `salary_details_to_deduction`
  MODIFY `salary_details_to_deduction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_details_to_leave`
--
ALTER TABLE `salary_details_to_leave`
  MODIFY `salary_details_to_leave_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_rule`
--
ALTER TABLE `tax_rule`
  MODIFY `tax_rule_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `termination`
--
ALTER TABLE `termination`
  MODIFY `termination_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_info`
--
ALTER TABLE `training_info`
  MODIFY `training_info_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `training_type`
--
ALTER TABLE `training_type`
  MODIFY `training_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `warning`
--
ALTER TABLE `warning`
  MODIFY `warning_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weekly_holiday`
--
ALTER TABLE `weekly_holiday`
  MODIFY `week_holiday_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_shift`
--
ALTER TABLE `work_shift`
  MODIFY `work_shift_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
