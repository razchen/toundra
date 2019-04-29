@extends('layouts.admin')

@section('header','User: '.$user->name)
@section('breadcrumbs')
<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
<li class="active">Users</li>
@stop

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <label>User</label>
                <p>{{ $user->name }}</p>

                <label>Email</label>
                <p>{{ $user->email }}</p>

                <label>Type</label>
                <p>{{ $user->type }}</p>
            </div>
           <!--  <div class="box-footer">
                <form action="{{ url('/admin/users', ['id' => $user->id]) }}" method="post">

                    <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-primary">Edit</a>
                    
                    <input class="btn btn-danger" type="submit" value="Delete" />
                    <input type="hidden" name="_method" value="delete" />
                    {!! csrf_field() !!}
                </form>
            </div> -->

            <div class="box-footer">
                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-primary">Edit</a>
                <form action="/admin/users/{{ $user->id }}" method="post" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="input" class="btn btn-danger">Delete</a>
                </form>
            </div>
        </div>
    </div>
</div>

@stop