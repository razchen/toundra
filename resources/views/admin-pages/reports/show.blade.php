@extends('layouts.admin')

@section('header','Report: '.$report->instance_id)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Reports</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		<div class="box box-info">
			<div class="box-body">
				<label>Control Definition</label>
				<p>{{ $report->control_definition->name }}</p>

				<label>JSON</label>
				<p>{{ $report->json_data }}</p>

				<label>Status</label>
				<p>{{ $report->active ? 'Active' : 'Inactive' }}</p>

			</div>
			<div class="box-footer">
				<a href="/admin/reports/{{ $report->id }}/edit" class="btn btn-primary">Edit</a>
				<form action="/admin/reports/{{ $report->id }}" method="post" style="display:inline">
					@csrf
					@method('DELETE')
					<button type="input" class="btn btn-danger">Delete</a>
				</form>
			</div>
		</div>
	</div>
</div>

@stop