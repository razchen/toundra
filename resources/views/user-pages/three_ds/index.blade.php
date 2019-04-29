@extends('layouts.admin')

@section('header','Models')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Models</li>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-6">
			@include('messages')
			<div class="box box-info">
				<div class="box-body">
					@if(count($three_ds))
						<div class="table table-responsive">
							<table class="table no-margin">
								<tr>
									<th>Name</th>
									<th>Updated At</th>
								</tr>
								@foreach ($three_ds as $three_d)
									<tr>
										<td>
											<a href="/models/{{ $three_d->id }}">{{ $three_d->name }}</a>
										</td>
										<td>
											{{ date('d-m-Y H:i:s',strtotime($three_d->updated_at)) }}
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					@else
						<p>Please create a new model by clicking <a href="/models/create">HERE</a></p>
					@endif
				</div>

				<div class="box-footer">
					<a href="/models/create" class="btn btn-primary">Create</a>
				</div>
			</div>
		</div>
	</div>

@stop