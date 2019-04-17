@extends('layouts.admin')

@section('header','Edit '.$three_d->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Models</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-8">
		@include('errors')

		<form method="POST" action="/models/{{ $three_d->id }}" class="needs-validation" novalidate>
			{{ csrf_field() }}
			{{ method_field('PATCH') }}

			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">
						<label>Model Name</label>
						<input 
							class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
							type="text" 
							name="name" 
							placeholder="Model Name" 
							value="{{ $three_d->name }}">
					</div>

					<div class="form-group">
						<label>Point Of View</label>
						<textarea 
							class="form-control {{ $errors->has('point_of_view') ? 'is-invalid' : '' }}" 
							name="point_of_view" 
							placeholder="Point Of View">{{ $three_d->point_of_view }}</textarea>
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