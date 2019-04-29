@extends('layouts.admin')

@section('header','Users')
@section('breadcrumbs')
<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
<li class="active">Users</li>
@stop

@section('content')

<div class="row">
    <div class="col-lg-6">
	
        @if(isset($message))
        <div class="alert alert-success" role="alert">
            {{$message}}
        </div>
        @endif

        <div class="box box-info">
            <div class="box-body">
                @if(count($users))
                <div class="table table-responsive">
                    <table class="table no-margin">
                        <tr>
                            <th>Name</th>
                            <th>Updated At</th>
                        </tr>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <a href="/admin/users/{{ $user->id }}">{{ $user->name }}</a>
                            </td>
                            <td>
                                {{ date('d-m-Y H:i:s',strtotime($user->updated_at)) }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @else
                <p>Please create a new user by clicking <a href="/admin/users/create">HERE</a></p>
                @endif
            </div>

            <div class="box-footer">
                <a href="/admin/users/create" class="btn btn-primary">Create</a>
            </div>
        </div>
    </div>
</div>
@stop