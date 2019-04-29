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

    public function index()
    {
        if (request()->wantsJson()) {
            return response()->JSON(Report::getAllAuthReports());
        } else {
            return view('user-pages.reports.index',[
                'reports' => Report::getAllAuthReports()
            ]);
        }
    }

    public function create()
    {
        if (request()->wantsJson())
            return null;
        
 		return view('user-pages.reports.create',[
            'control_definitions' => auth()->user()->control_definitions
        ]);
    }

    public function edit(Report $report)
    {
        if (request()->wantsJson())
            return null;
        
        $this->authorize('view',$report);
        $control_definitions = auth()->user()->control_definitions;

 		return view('user-pages.reports.edit')->with(compact('report','control_definitions'));
    }

    public function show(Report $report)
    {
    	$this->authorize('view',$report);

        if (request()->wantsJson()) {
            return response()->JSON($report);
        } else {
            return view('user-pages.reports.show')->with(compact('report'));
        }   
    }

    public function update(Report $report)
    {
    	$this->authorize('update',$report);

    	$attributes = $this->validateReport();

    	$report->update($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($report);
        } else {
            return redirect('/reports');
        }
    }

    public function store(Report $report)
    {
        $this->authorize('store', $report);

    	$attributes = $this->validateReport();

 		$report = Report::create($attributes);

 		if (request()->wantsJson()) {
            return response()->JSON($report);
        } else {
            return redirect('/reports');
        }
    }

    public function destroy(Report $report)
    {
        $report->control_definition->user_id != auth()->user()->id ? abort(403) : $report->delete();

        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/reports');
        }
    }

    protected function validateReport()
    {
    	return request()->validate([
    		'control_definition_id' => 'required',
    		'instance_id' => 'required'
    	]);
    }
}
