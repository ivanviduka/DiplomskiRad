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
                    <h4 class="card-title" style="text-align: center">{{$details->user_file_name}}</h4>
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
                            <p class="card-text"><strong>Year of study: </strong> {{$details->subject->year_of_study}}
                            </p>
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

        @if (count($comments) > 0)
            <div class="container-fluid mt-5">
                <h4 class="mt-3">Comments</h4>
                @foreach($comments as $comment)
                    <div class="card mb-3 col-md-6">
                        <div class="col-md-12">
                            <div class="card-body">
                                <div class="card-text" style="display: flex; align-items: center;">
                                    <strong> {{$comment->user->first_name}} {{$comment->user->last_name}}</strong>
                                    @if(auth()->user()->is_admin || $comment->user_id == auth()->user()->id)
                                        <form action="{{route('delete.comment', [$comment])}}"  method="POST">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-default btn-sm" aria-label="delete file"
                                                    onclick="return confirm('Are you sure you want to delete this file?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5
                                                 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3
                                                  .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd"
                                                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1
                                                   1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1
                                                    0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0
                                                     1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>


                                <p class="card-text mt-2">{{$comment->comment_text}} </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="container-fluid mt-5">
            <div class="card mb-3 col-md-6" style="border: none">
                <div class="col-md-12">
                    <div class="card-body">
                        <label for="commentText" class="form-label"> <h5>Leave a comment</h5> </label>
                        <form method="POST" action={{route('add.comment')}}>
                            @csrf
                            <div class="form-group">
                                <div class="mb-3">
                                     <textarea type="text" id="commentText" name="comment" rows=3 cols=2 class="form-control"
                                               id="commentText">{{old('comment')}}</textarea>
                                </div>
                                <input type="hidden" name="file_id" value="{{ $details->id }}"/>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary btn-block mt-2">
                                Add Comment
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>


    @endif

@endsection
