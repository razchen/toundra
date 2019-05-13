@extends('layouts.admin')

@section('header','Protocol: '.$protocol->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Protocols</li>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<div class="box box-info">
				<div class="box-body">
					<label>Description</label>
					<p>{{ $protocol->description }}</p>

					<label>JSON</label>
					<p>{{ $protocol->json_data }}</p>
				</div>

				<div class="box-footer">
					<a href="/protocols/{{ $protocol->id }}/edit" class="btn btn-primary">Edit</a>
					<form action="/protocols/{{ $protocol->id }}" method="post" style="display:inline">
						@csrf
						@method('DELETE')
						<button type="input" class="btn btn-danger">Delete</a>
					</form>
				</div>
			</div>
		</div>
	</div>

@stop