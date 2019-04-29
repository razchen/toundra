@extends('layouts.admin')

@section('header','Cameras')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Cameras</li>
@stop

@section('content')

	<div class="row">
		<div class="col-lg-6">
			@include('messages')
			<div class="box box-info">
				<div class="box-body">
					@if(count($cameras))
						<div class="table table-responsive">
							<table class="table no-margin">
								<tr>
									<th>Name</th>
									<th>Updated At</th>
								</tr>
								@foreach ($cameras as $camera)
									<tr>
										<td>
											<a href="/admin/cameras/{{ $camera->id }}">{{ $camera->name }}</a>
										</td>
										<td>
											{{ date('d-m-Y H:i:s',strtotime($camera->updated_at)) }}
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					@else
						<p>Please create a new camera by clicking <a href="/admin/cameras/create">HERE</a></p>
					@endif
				</div>

				<div class="box-footer">
					<a href="/admin/cameras/create" class="btn btn-primary">Create</a>
				</div>
			</div>
		</div>
	</div>
@stop