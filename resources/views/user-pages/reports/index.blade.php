@extends('layouts.admin')

@section('header','Reports')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Reports</li>
@stop

@section('content')

	<div class="row">
		<div class="col-lg-6">
			<div class="box box-info">
				<div class="box-body">
					@if(count($reports))
						<div class="table table-responsive">
							<table class="table no-margin">
								<tr>
									<th>Instance ID</th>
									<th>Updated At</th>
								</tr>

								@foreach ($reports as $report)
								<tr>
									<td>
										<a href="/reports/{{ $report->id }}">{{ $report->instance_id }}</a>
									</td>
									<td>
										{{ date('d-m-Y H:i:s',strtotime($report->updated_at)) }}
									</td>
								</tr>
								@endforeach
							</table>
						</div>
					@else
						<p>Please create a new report by clicking <a href="/reports/create">HERE</a></p>
					@endif
				</div>

				<div class="box-footer">
					<a href="/reports/create" class="btn btn-primary">Create</a>
				</div>
			</div>
		</div>
	</div>
@stop