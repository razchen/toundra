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
			<div class="box box-info dataTables_wrapper form-inline dt-bootstrap">
				<div class="box-body">
					@if(count($cameras))	
						<form class="form-horizontal" method="get">
							Filter by &nbsp;
							<select name="filters" class="form-control">
								<option value="name" {{ request()->get('filters') == 'name' ? 'selected' : null }}>Name</option>
								<option value="intrinsic" {{ request()->get('filters') == 'intrinsic' ? 'selected' : null }}>Intrinsic</option>
							</select>
						
							<input type="text" class="form-control" name="filter_value" placeholder="filter value" value="{{ request()->get('filter_value') }}">
						
							<button type="submit" class="btn btn-default"><span class="fa fa-search"></span></button>
						</form><br>
							
						<div class="table table-responsive">
							<table class="table no-margin">
								<tr>
									<th>Name</th>
									<th>Updated At</th>
								</tr>
								@foreach ($cameras as $camera)
									<tr>
										<td>
											<a href="/cameras/{{ $camera->id }}">{{ $camera->name }}</a>
										</td>
										<td>
											{{ date('d-m-Y H:i:s',strtotime($camera->updated_at)) }}
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					@elseif (request()->input('filters'))
						<p>No matches found</p>
					@else
						<p>Please create a new camera by clicking <a href="/cameras/create">HERE</a></p>
					@endif
				</div>

				<div class="box-footer">
					<a href="/cameras/create" class="btn btn-primary">Create</a>
				</div>
			</div>
		</div>
	</div>
@stop