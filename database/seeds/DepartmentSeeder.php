<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('department')->truncate();
        DB::table('department')->insert(
            [
                ['department_name' => 'HR','created_at'=>$time,'updated_at'=>$time],
                ['department_name' => 'Management','created_at'=>$time,'updated_at'=>$time],
                ['department_name' => 'PHP','created_at'=>$time,'updated_at'=>$time],
                ['department_name' => 'Accounts','created_at'=>$time,'updated_at'=>$time],
                ['department_name' => 'JAVA','created_at'=>$time,'updated_at'=>$time],

            ]

        );
    }
}
