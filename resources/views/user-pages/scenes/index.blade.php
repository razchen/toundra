@extends('layouts.admin')

@section('header','Scenes')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Scenes</li>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-6">
			@include('messages')
			<div class="box box-info">
				<div class="box-body">
					@if(count($scenes))
						<div class="table table-responsive">
							<table class="table no-margin">
								<tr>
									<th>Name</th>
									<th>Status</th>
									<th>Updated At</th>
								</tr>
								@foreach ($scenes as $scene)
									<tr>
										<td>
											<a href="/scenes/{{ $scene->id }}">{{ $scene->name }}</a>
										</td>
										<td>
											{{ $scene->active ? 'Active' : 'Inactive' }}
										</td>
										<td>
											{{ date('d-m-Y H:i:s',strtotime($scene->updated_at)) }}
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					@else
						<p>Please create a new scene by clicking <a href="/scenes/create">HERE</a></p>
					@endif
				</div>

				<div class="box-footer">
					<a href="/scenes/create" class="btn btn-primary">Create</a>
				</div>
			</div>
		</div>
	</div>

@stop