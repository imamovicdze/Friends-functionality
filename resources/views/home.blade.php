@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                        <a class="nav-link" href="{{ url('users') }}">{{ __('All Users') }}</a>
                        <a class="nav-link" href="{{ url('requests') }}">{{ __('All Requests') }}</a>
                        <a class="nav-link" href="{{ url('friends') }}">{{ __('All Friends') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
