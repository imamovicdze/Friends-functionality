@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
{{--                @if ($message = Session::get('success'))--}}
{{--                    <div class="alert alert-success alert-block">--}}
{{--                        <button type="button" class="close" data-dismiss="alert">×</button>--}}
{{--                        <strong>{{ $message }}</strong>--}}
{{--                    </div>--}}
{{--                @endif--}}
                <table class="table table-striped">
                    <tr>
                        <th>Send Request</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($requests as $request)
                        <tr>
                            <td>UserId: {{ $request->user_id_sent }}</td>
                            <td>{{ $request->status }}</td>
                            <td>
                                <a href="#0" class="btn btn-success" role="button">Accept</a>
                                <a href="#0" class="btn btn-danger" role="button">Decline</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
