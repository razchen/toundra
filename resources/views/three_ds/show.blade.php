@extends('layouts.admin')

@section('header','Model: '.$three_d->name)
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Models</li>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<div class="box box-info">
				<div class="box-body">
					<label>Point Of View</label>
					<p>{{ $three_d->point_of_view }}</p>
				</div>

				<div class="box-footer">
					<a href="/models/{{ $three_d->id }}/edit" class="btn btn-primary">Edit</a>
				</div>
			</div>
		</div>
	</div>
@stop