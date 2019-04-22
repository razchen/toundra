@extends('layouts.admin')

@section('header','Create Camera')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Cameras</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		@include('errors')

		<div class="box box-info">
			<form method="POST" action="/cameras" class="needs-validation" novalidate>
				{{ csrf_field() }}
				<div class="box-body">
					<div class="form-group">
						<label>Camera Name</label>
						<input 
							class="form-control" 
							value="{{ old('name') }}"
							type="text" 
							name="name" 
							placeholder="Camera name">
					</div>

					<div class="form-group">
						<label>Intrinsic Parameters</label>
						<textarea 
							class="form-control" 
							name="intrinsic" 
							placeholder="Intrinsic Parameters" 
							required>{{ old('intrinsic') }}</textarea>
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