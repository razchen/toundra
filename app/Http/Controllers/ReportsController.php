<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class ReportsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
 		return view('user-pages.reports.index',[
 			'reports' => auth()->user()->control_definitions->reports
 		]);
    }

    public function create()
    {
 		return view('user-pages.reports.create',[
            'scenes' => auth()->user()->scenes
        ]);
    }

    public function edit(Report $report)
    {
        $this->authorize('view',$report);
        $scenes = auth()->user()->scenes;

 		return view('user-pages.reports.edit')->with(compact('report','report'));
    }

    public function show(Report $report)
    {
    	$this->authorize('view',$report);

 		return view('user-pages.reports.show')->with(compact('report'));
    }

    public function update(Report $report)
    {
    	$this->authorize('update',$report);

    	$attributes = $this->validateReport();

    	$report->update($attributes);

    	return redirect('/reports');
    }

    public function store(Report $report)
    {
        $this->authorize('store', $report);

    	$attributes = $this->validateReport();
    	$attributes['user_id'] = auth()->id();

 		Report::create($attributes);

 		return redirect('/reports');
    }

    protected function validateReport()
    {
    	return request()->validate([
    		'name' => 'required',
    		'transforms' => 'required|json',
            'active' => 'required|in:0,1',
            'camera_id' => 'required',
    	]);
    }
}
