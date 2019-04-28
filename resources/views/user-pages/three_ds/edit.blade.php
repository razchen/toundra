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

		<form method="POST" action="/models/{{ $three_d->id }}" class="needs-validation" enctype="multipart/form-data" novalidate>
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
						<label>Description</label>
						<textarea 
							class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" 
							name="description" 
							placeholder="Description">{{ $three_d->description }}</textarea>
					</div>

					@if (count($three_d->files))
						<div class="form-group">
							<label>Uploaded Files</label>
							@foreach ($three_d->files as $file) 
								<div>
									<a href="/stls/{{ $file->filename }}">{{ $file->filename }}</a>
								</div>
							@endforeach
						</div>
					@endif

					<div class="form-group">
						<label>File Upload</label><br>
						<label class="btn btn-default">
						    <input type="file" hidden name="3dfile">
						</label>
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