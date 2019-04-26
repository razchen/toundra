@extends('layouts.admin')

@section('header','Control Definitions')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Control Definitions</li>
@stop

@section('content')

	<div class="row">
		<div class="col-lg-6">
			<div class="box box-info">
				<div class="box-body">
					@if(count($control_definitions))
						<div class="table table-responsive">
							<table class="table no-margin">
								<tr>
									<th>Name</th>
									<th>Updated At</th>
								</tr>
								@foreach ($control_definitions as $control_definition)
									<tr>
										<td>
											<a href="/control-definitions/{{ $control_definition->id }}">{{ $control_definition->name }}</a>
										</td>
										<td>
											{{ date('d-m-Y H:i:s',strtotime($control_definition->updated_at)) }}
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					@else
						<p>Please create a new control definition by clicking <a href="/control-definitions/create">HERE</a></p>
					@endif
				</div>

				<div class="box-footer">
					<a href="/control-definitions/create" class="btn btn-primary">Create</a>
				</div>
			</div>
		</div>
	</div>
@stop