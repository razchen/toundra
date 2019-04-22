@extends('layouts.admin')

@section('header','Create Model')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Models</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-8">
		@include('errors')

		<form method="POST" action="/models" class="needs-validation" novalidate>
			{{ csrf_field() }}

			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">
						<label>Model Name</label>
						<input 
							class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
							value="{{ old('name') }}"
							type="text" 
							name="name" 
							placeholder="Model name">
					</div>

					<div class="form-group">
						<label>Description</label>
						<textarea 
							class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" 
							name="description" 
							placeholder="Description">{{ old('description') }}</textarea>
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