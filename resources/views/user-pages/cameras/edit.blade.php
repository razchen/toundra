@extends('layouts.admin')

@section('header','Edit '.$camera->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Cameras</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		@include('errors')

		<div class="box box-info">
			<form method="POST" action="/cameras/{{ $camera->id }}" class="needs-validation" novalidate>
				{{ csrf_field() }}
				{{ method_field('PATCH') }}
				<div class="box-body">
					<div class="form-group">
						<label>Camera Name</label>
						<input 
							class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
							type="text" 
							name="name" 
							placeholder="Camera Name" 
							value="{{ $camera->name }}">
					</div>

					<div class="form-group">
						<label>Intrinsic Parameters</label>
						<textarea 
							class="form-control {{ $errors->has('intrinsic') ? 'is-invalid' : '' }}" 
							name="intrinsic" 
							placeholder="Intrinsic Parameters">{{ $camera->intrinsic }}</textarea>
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