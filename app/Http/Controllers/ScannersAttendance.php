<?php

namespace App\Http\Controllers;

use App\Scanner;
use Illuminate\Http\Request;

class ScannersAttendance extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $now = $request->Input(['fingerid']);
        echo $user = DB::table('employee')->where('finger_print_id', $now)->first();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Scanner  $scanner
     * @return \Illuminate\Http\Response
     */
    public function show(Scanner $scanner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Scanner  $scanner
     * @return \Illuminate\Http\Response
     */
    public function edit(Scanner $scanner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scanner  $scanner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scanner $scanner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Scanner  $scanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scanner $scanner)
    {
        //
    }
}
