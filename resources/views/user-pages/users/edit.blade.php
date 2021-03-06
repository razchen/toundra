@extends('layouts.admin')

@section('header','Edit '.$user->name)
@section('breadcrumbs')
<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
<li class="active">Users</li>
@stop

@section('content')

<div class="row">
    <div class="col-lg-6">
        @include('errors')

        <div class="box box-info">
            <form method="POST" action="/admin/users/{{ $user->id }}" class="needs-validation" novalidate>
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="box-body">

                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type">
                            <option value="" {{ ($user->type == '' ? 'selected' : null) }}>User</option>
                            <option value="admin" {{ ($user->type == 'admin' ? 'selected' : null) }}>Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" value="{{ $user->name }}" type="text" name="name"
                            placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" value="{{ $user->email }}" type="text" name="email"
                            placeholder="Email">
                    </div>

                    <div class="form-group">
                        <label>API KEY</label>
                        <input class="form-control" value="{{ $user->api_key }}" type="text" name="api_key"
                            placeholder="API KEY">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Password">
                    </div>

                    <div class="box-footer">
                        <input class="btn btn-primary" type="submit" value="Submit" />
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@stop