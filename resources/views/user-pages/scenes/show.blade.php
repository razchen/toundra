@extends('layouts.admin')

@section('header','Scene: '.$scene->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Scenes</li>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<div class="box box-info">
				<div class="box-body">
					<label>Range of likely transforms</label>
					<p>{{ $scene->transforms }}</p>

					<label>Status</label>
					<p>{{ $scene->active ? 'Active' : 'Inactive' }}</p>

					<label>Camera</label>
					<p>{{ isset($scene->camera) ? $scene->camera->name : null }}</p>
				</div>

				<div class="box-footer">
					<a href="/scenes/{{ $scene->id }}/edit" class="btn btn-primary">Edit</a>
					<form action="/scenes/{{ $scene->id }}" method="post" style="display:inline">
						@csrf
						@method('DELETE')
						<button type="input" class="btn btn-danger">Delete</a>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop