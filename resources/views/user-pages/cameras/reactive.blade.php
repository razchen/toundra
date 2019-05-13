@extends('layouts.admin')

@section('header','Cameras')
@section('breadcrumbs')
	<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Cameras</li>
@stop

@section('content')
	<div class="row">
		<div class="col-lg-6" id="app">
			<router-view></router-view>
		</div>
	</div>
@stop