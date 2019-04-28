@extends('layouts.admin')

@section('header','Control Definition: '.$control_definition->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Control Definition</li>
@stop

@section('content')

<div class="row">
	<div class="col-lg-6">
		<div class="box box-info">
			<div class="box-body">
				<label>User</label>
				<p>{{ $control_definition->user->name }}</p>

				<label>Description</label>
				<p>{{ $control_definition->description }}</p>

				<label>JSON</label>
				<p>{{ $control_definition->json_data }}</p>

				<label>Model</label>
				<p>{{ isset($control_definition->three_d) ? $control_definition->three_d->name : null }}</p>

				<label>Protocol</label>
				<p>{{ isset($control_definition->protocol) ? $control_definition->protocol->name : null }}</p>
			</div>
			<div class="box-footer">
				<a href="/admin/control-definitions/{{ $control_definition->id }}/edit" class="btn btn-primary">Edit</a>
				<form action="/admin/control-definitions/{{ $control_definition->id }}" method="post" style="display:inline">
					@csrf
					@method('DELETE')
					<button type="input" class="btn btn-danger">Delete</a>
				</form>
			</div>
		</div>
	</div>
</div>

@stop