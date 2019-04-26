@extends('layouts.admin')

@section('header','Create Control Definition')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Control Definitions</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		@include('errors')

		<div class="box box-info">
			<form method="POST" action="/control-definitions" class="needs-validation" novalidate>
				{{ csrf_field() }}
				<div class="box-body">
					<div class="form-group">
						<label>Control Definition Name</label>
						<input 
							class="form-control" 
							value="{{ old('name') }}"
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
								<option value="{{ $three_d->id }}">{{ $three_d->name }}</option>
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
								<option value="{{ $protocol->id }}">{{ $protocol->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Description</label>
						<textarea 
							class="form-control" 
							name="description" 
							placeholder="Description" 
							required>{{ old('description') }}</textarea>
					</div>

					<div class="form-group">
						<label>JSON</label>
						<textarea 
							class="form-control" 
							name="json_data" 
							placeholder="JSON" 
							required>{{ old('json_data') }}</textarea>
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