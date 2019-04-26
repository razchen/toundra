@extends('layouts.admin')

@section('header','Edit '.$control_definition->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Control Definition</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		@include('errors')

		<div class="box box-info">
			<form method="POST" action="/control-definitions/{{ $control_definition->id }}" class="needs-validation" novalidate>
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="box-body">
					<div class="form-group">
						<label>Control Definition Name</label>
						<input 
							class="form-control" 
							value="{{ $control_definition->name }}"
							type="text" 
							name="name" 
							placeholder="Control Definition Name">
					</div>

					<div class="form-group">
						<label>Choose a Model</label>
						<select 
							class="form-control"
							name="three_d_id"
							placeholder="Model">
							@foreach ($three_ds as $three_d)
								<option value="{{ $three_d->id }}" {{ $three_d->id == $control_definition->three_d_id ? 'selected' : null }}>{{ $three_d->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Choose a Protocol</label>
						<select 
							class="form-control"
							name="protocol_id"
							placeholder="Protocol">
							@foreach ($protocols as $protocol)
								<option value="{{ $protocol->id }}" {{ $protocol->id == $control_definition->protocol_id ? 'selected' : null }}>{{ $protocol->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Description</label>
						<textarea 
							class="form-control" 
							name="description" 
							placeholder="Description" 
							required>{{ $control_definition->description }}</textarea>
					</div>

					<div class="form-group">
						<label>JSON</label>
						<textarea 
							class="form-control" 
							name="json_data" 
							placeholder="JSON" 
							required>{{ $control_definition->json_data }}</textarea>
					</div>

				<div class="box-footer">
					<input class="btn btn-primary" type="submit" value="Submit" />
				</div>
			</form>
		</div>
	</div>
</div>

@stop