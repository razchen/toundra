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

    public function index()
    {
 		return view('admin-pages.reports.index',[
 			'reports' => Report::orderBy('updated_at','desc')->get()
 		]);
    }

    public function create()
    {
 		return view('admin-pages.reports.create',[
            'control_definitions' => ControlDefinition::orderBy('name','asc')->get()
        ]);
    }

    public function edit(Report $report)
    {
        $control_definitions = ControlDefinition::orderBy('name','asc')->get();

 		return view('admin-pages.reports.edit')->with(compact('report','control_definitions'));
    }

    public function show(Report $report)
    {
 		return view('admin-pages.reports.show')->with(compact('report'));
    }

    public function update(Report $report)
    {
    	$attributes = $this->validateReport();

    	$report->update($attributes);

    	return redirect('/admin/reports');
    }

    public function store(Report $report)
    {
    	$attributes = $this->validateReport();

 		Report::create($attributes);

 		return redirect('/admin/reports');
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return redirect('/admin/reports')->with('message','The report ' . $report->instance_id . ' deleted successfully');
    }

    protected function validateReport()
    {
    	return request()->validate([
    		'control_definition_id' => 'required',
    		'instance_id' => 'required'
    	]);
    }
}
