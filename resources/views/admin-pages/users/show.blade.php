@extends('layouts.admin')

@section('header','User: '.$user->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Users</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		<div class="box box-info">
			<div class="box-body">
				<label>User</label>
				<p>{{ $user->name }}</p>

				<label>Intrinsic Parameters</label>
				<p>{{ $user->intrinsic }}</p>
			</div>
			<div class="box-footer">
				<a href="/admin/users/{{ $user->id }}/edit" class="btn btn-primary">Edit</a>
			</div>
		</div>
	</div>
</div>

@stop