<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('designation')->truncate();
        DB::table('designation')->insert(
            [
                ['designation_name' => 'Director','created_at'=>$time,'updated_at'=>$time],
                ['designation_name' => 'CTO','created_at'=>$time,'updated_at'=>$time],
                ['designation_name' => 'Sr.Executive','created_at'=>$time,'updated_at'=>$time],
                ['designation_name' => 'Sr.Developer','created_at'=>$time,'updated_at'=>$time],
                ['designation_name' => 'Jr.Developer','created_at'=>$time,'updated_at'=>$time],

            ]

        );
    }
}
