@extends('layouts.admin')

@section('header','Create Scene')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Scenes</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-8">
		@include('errors')

		<form method="POST" action="/scenes" class="needs-validation" novalidate>
			{{ csrf_field() }}

			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">
						<label>Scene Name</label>
						<input 
							class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
							value="{{ old('name') }}"
							type="text" 
							name="name" 
							placeholder="Scene name">
					</div>

					<div class="form-group">
						<label>Choose a Camera</label>
						<select 
							class="form-control"
							name="camera_id"
							placeholder="Camera">
							@foreach ($cameras as $camera)
								<option value="{{ $camera->id }}">{{ $camera->name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Range of likely transforms</label>
						<textarea 
							class="form-control {{ $errors->has('transforms') ? 'is-invalid' : '' }}" 
							name="transforms" 
							placeholder="Range of likely transforms">{{ old('transforms') }}</textarea>
					</div>

					<div class="form-group">
						<label>Status</label>
						<select 
							class="form-control"
							name="active"
							placeholder="Active">
							<option value="0" {{ !old('active') ? 'selected' : null }}>Inactive</option>
							<option value="1" {{ old('active') ? 'selected' : null }}>Active</option>
						</select>
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