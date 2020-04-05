@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            @if ($user->status == 'Pending')
                                <td><a href="#0" class="btn btn-outline-success" role="button" style="pointer-events: none;">Pending</a></td>
                            @elseif ($user->status == 'Approved')
                                <td>Friend</td>

                            @elseif ($user->status == 'Declined')
                                <td>User has declined your request!</td>

                            @else
                                <td><a href="/send-request/{{ $user->id }}" class="btn btn-outline-dark" role="button">Send
                                        request</a></td>
                            @endif

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
