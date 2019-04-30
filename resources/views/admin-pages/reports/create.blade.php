@extends('layouts.admin')

@section('header','Create Report')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
	<li class="active">Reports</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		@include('errors')

		<div class="box box-info">
			<form method="POST" action="/admin/reports" class="needs-validation" novalidate>
				{{ csrf_field() }}
				<div class="box-body">
					<div class="form-group">
						<label>Control Definition</label>
						<select class="form-control" name="control_definition_id">
							@foreach($control_definitions as $control_definition)
								<option value="{{ $control_definition->id }}">{{ $control_definition->id }} -{{ $control_definition->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Inastance ID</label>
						<input 
							class="form-control" 
							value="{{ old('instance_id') }}" 
							type="text" 
							name="instance_id"
							placeholder="Instance ID">
					</div>

					<div class="form-group">
						<label>JSON</label>
						<textarea class="form-control" name="json_data" placeholder="JSON"
							required>{{ old('json_data') }}</textarea>
					</div>

					<div class="form-group">
						<label>Status</label>
						<select 
							class="form-control"
							name="active"
							placeholder="Active"
							required>
							<option value="0" {{ !old('active') ? 'selected' : null }}>Inactive</option>
							<option value="1" {{ old('active') ? 'selected' : null }}>Active</option>
						</select>
					</div>
				</div>

				<div class="box-footer">
					<input class="btn btn-primary" type="submit" value="Submit" />
				</div>
			</form>
		</div>
	</div>
</div>
@stop