@extends('layouts.admin')

@section('header','Model: '.$three_d->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Models</li>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<div class="box box-info">
				<div class="box-body">
					<label>Description</label>
					<p>{{ $three_d->description }}</p>

					@if (count($three_d->files))
						<label>Uploaded Files</label>
						@foreach ($three_d->files as $file) 
							<div>
								<a href="/stls/{{ $file->filename }}">{{ $file->filename }}</a>
							</div>
						@endforeach
					@endif
				</div>

				<div class="box-footer">
					<a href="/models/{{ $three_d->id }}/edit" class="btn btn-primary">Edit</a>
					<form action="/models/{{ $three_d->id }}" method="post" style="display:inline">
						@csrf
						@method('DELETE')
						<button type="input" class="btn btn-danger">Delete</a>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop