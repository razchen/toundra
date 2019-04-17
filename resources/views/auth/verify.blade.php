@extends('layouts.admin')

@section('header','Verify Your Email Address')
@section('breadcrumbs')
    <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Verify Your Email Address</li>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Verify Your Email Address') }}</div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
            </div>
        </div>
    </div>
</div>
@endsection
