@extends('layouts.admin')

@section('header','Create User')
@section('breadcrumbs')
<li><a href="/"><i class="fa fa-home"></i> Home</a></li>
<li class="active">Users</li>
@stop

@section('content')

<div class="row">
    <div class="col-lg-6">
        @include('errors')

        <div class="box box-info">
            <form method="POST" action="/admin/users" class="needs-validation" novalidate>
                {{ csrf_field() }}
                <div class="box-body">

                    <label>Type</label>
                    <select class="form-control" name="type">

                        <option value="''" >User</option>
                        <option value="admin" >Admin</option>

                    </select>


                    <div class="form-group">
                        <label>User Name</label>
                        <input class="form-control" value="{{ old('name') }}" type="text" name="name"
                            placeholder="User name">
                    </div>

                    <div class="form-group">
                        <label>API KEY</label>
                        <input class="form-control" value="{{ old('name') }}" type="text" name="api_key"
                            placeholder="API KEY">
                    </div>

					<div class="form-group">
                        <label>Email</label>
                        <input class="form-control" value="{{ old('email') }}" type="text" name="email"
                            placeholder="Email">
                    </div>

					<div class="form-group">
                        <label>Confirm Password</label>
                        <input class="form-control" value="{{ old('password') }}" type="password" name="password"
                            placeholder="Confirm password">
                    </div>

                </div>

                <div class="box-footer">
                    <input class="btn btn-primary" type="submit" value="Submit" />
                </div>
            </form>
        </div>
    </div>
</div>
@stop