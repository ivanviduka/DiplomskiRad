@extends('layouts.header')

@section('title')
    <title>Admin Statistics</title>
@endsection

@section('description')
    <meta name="description" content="Display of app statistics">
@endsection

@section('content')
    @if(isset($statistics))
        <div class="container mt-5 mb-5">
            <div class="card mx-auto">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Number of users: </strong>{{$statistics->users}}</li>
                    <li class="list-group-item"><strong>Number of public files: </strong>{{$statistics->public_files}}</li>
                    <li class="list-group-item"><strong>Number of private files: </strong>{{$statistics->private_files}}</li>
                    <li class="list-group-item"><strong>Total number of files: </strong>{{$statistics->public_files + $statistics->private_files}}</li>
                </ul>
            </div>
        </div>
    @endif
@endsection
