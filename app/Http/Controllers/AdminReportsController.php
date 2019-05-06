<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\User;
use App\ControlDefinition;

class AdminReportsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('admin');
	}

    /**
     * Display a listing of the Reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 		return view('admin-pages.reports.index',[
 			'reports' => Report::orderBy('updated_at','desc')->get()
 		]);
    }

    /**
     * Show the form for creating a new Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 		return view('admin-pages.reports.create',[
            'control_definitions' => ControlDefinition::orderBy('name','asc')->get()
        ]);
    }

    /**
     * Show the form for editing the specified Report.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        $control_definitions = ControlDefinition::orderBy('name','asc')->get();

 		return view('admin-pages.reports.edit')->with(compact('report','control_definitions'));
    }

    /**
     * Display the specified Report.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
 		return view('admin-pages.reports.show')->with(compact('report'));
    }

    /**
     * Update the specified Report in storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Report $report)
    {
        $attributes = $this->validateReport();

    	$report->update($attributes);

    	return redirect('/admin/reports');
    }

    /**
     * Store a newly created Report in storage.
     * 
     *  @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function store(Report $report)
    {
    	$attributes = $this->validateReport();

 		Report::create($attributes);

 		return redirect('/admin/reports');
    }

    /**
     * Remove the specified Report from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect('/admin/reports')->with('message','The report ' . $report->instance_id . ' deleted successfully');
    }

    /**
     * Validate the specified report.
     *
     * @return  \Illuminate\Http\Request  $request
     */
    protected function validateReport()
    {
    	return request()->validate([
    		'control_definition_id' => 'required',
            'instance_id' => 'required',
            'json_data' => 'required|json',
            'active' => 'required'
    	]);
    }
}
