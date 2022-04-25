@extends('layouts.header')

@section('title')
    <title>File Details</title>
@endsection

@section('description')
    <meta name="description" content="Page with file details and comments">
@endsection


@section('content')

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger ms-3 me-3" role="alert">
                {{ $error}}
            </div>
        @endforeach
    @endif


    @if (isset($details))
        <div class="container-fluid mt-5">
            <div class="card mb-3 col-md-6">
                <div class="card-header">
                    <h5 class="card-title" style="text-align: center">{{$details->user_file_name}}</h5>
                </div>
                <div class="row py-3">
                    <div class="col-md-12">
                        <div class="card-body">
                            <p class="card-text">
                                <strong>Author:</strong> {{$details->user->first_name}} {{$details->user->last_name}}
                            </p>
                            <p class="card-text"><strong>Author email: </strong> {{$details->user->email}} </p>
                            <p class="card-text"><strong>Subject:</strong> {{$details->subject->subject_name}} </p>
                            <p class="card-text"><strong>Major:</strong> {{$details->subject->major_name}} </p>
                            <p class="card-text"><strong>Year of study: </strong> {{$details->subject->year_of_study}}</p>
                            <p class="card-text"><strong>Upload date:</strong>
                                {{ isset($details->updated_at)? \Carbon\Carbon::parse($details->updated_at)->format('d.m.Y') : "" }}
                            </p>
                            <p class="card-text"><strong>Download link: </strong>
                                <a class="me-2" href="{{ route('file.download', [$details]) }}">
                                    {{ $details->user_file_name . "." . $details->file_type }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
