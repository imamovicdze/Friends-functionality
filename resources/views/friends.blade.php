@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-striped">
                    <tr>
                        <th>Friends</th>
                    </tr>
                    @foreach ($friends as $friend)
                        <tr>
                            <td>UserId: {{ $friend->friend_id }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
