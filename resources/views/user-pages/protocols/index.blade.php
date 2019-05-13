@extends('layouts.admin')

@section('header','Protocols')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Protocols</li>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-6">
			@include('messages')
			<div class="box box-info">
				<div class="box-body">
					@if(count($protocols))
						<div class="table table-responsive">
							<table class="table no-margin">
								<tr>
									<th>Name</th>	
									<th>Updated At</th>
								</tr>
								@foreach ($protocols as $protocol)
									<tr>
										<td>
											<a href="/protocols/{{ $protocol->id }}">{{ $protocol->name }}</a>
										</td>
										<td>
											{{ date('d-m-Y H:i:s',strtotime($protocol->updated_at)) }}
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					@else
						<p>Please create a new protocol by clicking <a href="/protocols/create">HERE</a></p>
					@endif
				</div>

				<div class="box-footer">
					<a href="/protocols/create" class="btn btn-primary">Create</a>
				</div>
			</div>
		</div>
	</div>
@stop