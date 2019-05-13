@extends('layouts.admin')

@section('header','Edit '.$protocol->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Protocols</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		@include('errors')

		<form method="POST" action="/protocols/{{ $protocol->id }}" class="needs-validation" novalidate>
			{{ csrf_field() }}
			{{ method_field('PATCH') }}
			
			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">
						<label>Protocol Name</label>
						<input 
							class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
							type="text" 
							name="name" 
							placeholder="Protocol Name" 
							value="{{ $protocol->name }}">
					</div>

					<div class="form-group">
						<label>Description</label>
						<textarea 
							class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" 
							name="description" 
							placeholder="Description">{{ $protocol->description }}</textarea>
					</div>

					<div class="form-group">
						<label>JSON</label>
						<textarea 
							class="form-control {{ $errors->has('json_data') ? 'is-invalid' : '' }}" 
							name="json_data" 
							placeholder="JSON">{{ $protocol->json_data }}</textarea>
					</div>
				</div>

				<div class="box-footer">
					<input class="btn btn-primary" type="submit" value="Submit" />
				</div>
			</div>
		</form>
	</div>
</div>

@stop