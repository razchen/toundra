<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class ReportsController extends Controller
{
    public function __construct()
	{
		if (!request()->wantsJson()) {
            $this->middleware('auth');    
        }
	}

    /**
     * Display a listing of the Reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = auth()->user()->type == 'admin' ? Report::getAllReports() : Report::getAllAuthReports();
        if (request()->wantsJson()) {
            return response()->JSON($response);
        } else {
            return view('user-pages.reports.reactive',[
                'reports' => $response
            ]);
        }
    }

    /**
     * Show the form for creating a new Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->wantsJson())
            return null;
        
 		return view('user-pages.reports.reactive',[
            'control_definitions' => auth()->user()->control_definitions
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
        if (request()->wantsJson())
            return null;
        
        $this->authorize('view',$report);
        $control_definitions = auth()->user()->control_definitions;

 		return view('user-pages.reports.reactive')->with(compact('report','control_definitions'));
    }

     /**
     * Display the specified Report.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
    	$this->authorize('view',$report);

        if (request()->wantsJson()) {
            return $report->load('control_definition');
        } else {
            return view('user-pages.reports.reactive')->with(compact('report'));
        }   
    }

     /**
     * Update the specified Report in storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Report $report)
    {
    	$this->authorize('update',$report);

        $attributes = $this->validateReport();
        $attributes['user_id'] = auth()->user()->type == 'admin' ? request()->get('user_id') : auth()->id();

    	$report->update($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($report);
        } else {
            return redirect('/reports');
        }
    }

     /**
     * Store a newly created Report in storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function store(Report $report)
    {
        $this->authorize('store', $report);

        $attributes = $this->validateReport();
        $attributes['user_id'] = auth()->user()->type == 'admin' ? request()->get('user_id') : auth()->id();

 		$report = Report::create($attributes);

 		if (request()->wantsJson()) {
            return response()->JSON($report);
        } else {
            return redirect('/reports');
        }
    }

    /**
     * Remove the specified Report from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $this->authorize('view',$report); 
        $report->delete();

        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/reports')->with('message','The report ' . $report->name . ' deleted successfully');
        }
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
