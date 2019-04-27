@extends('layouts.admin')

@section('header','Camera: '.$camera->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Cameras</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		<div class="box box-info">
			<div class="box-body">
				<label>User</label>
				<p>{{ $camera->user->name }}</p>

				<label>Intrinsic Parameters</label>
				<p>{{ $camera->intrinsic }}</p>
			</div>
			<div class="box-footer">
				<a href="/admin/cameras/{{ $camera->id }}/edit" class="btn btn-primary">Edit</a>
			</div>
		</div>
	</div>
</div>

@stop