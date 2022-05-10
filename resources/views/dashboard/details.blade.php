@extends('layouts.header')

@section('title')
    <title>File Details</title>
@endsection

@section('description')
    <meta name="description" content="Page with file details and comments">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/comments_style.css') }}"/>
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

        <div class="d-flex justify-content-center">
            <div class="card mb-3 col-md-6 border border-dark">
                <div class="card-header" style="background-color: #009879;">
                    <h2 class="card-title" style="text-align: center">{{$details->user_file_name}}</h2>
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
                            <p class="card-text"><strong>Year of
                                    study: </strong> {{$details->subject->year_of_study}}
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

        <section class="mt-5">
            <div class="container">

                <div class="row mt-3">
                    @if (count($comments) > 0)
                        <h3>Comments</h3>
                        <div class="col-sm-5 col-md-6 col-12 pb-4">

                            @foreach($comments as $comment)
                                <div class="mb-3 comment border border-dark">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="card-text" style="display: flex; align-items: center;">
                                                <div class="icon icon-shape text-black ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                         fill="currentColor" class="bi bi-person-fill"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                    </svg>
                                                </div>
                                                <div class="mt-1">
                                            <span
                                                class="ms-2 me-2"> <strong> {{$comment->user->first_name}} {{$comment->user->last_name}}</strong> </span>
                                                    <span> {{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</span>
                                                </div>

                                                @if(auth()->user()->is_admin || $comment->user_id == auth()->user()->id)
                                                    <form action="{{route('delete.comment', [$comment])}}"
                                                          method="POST">
                                                        @csrf
                                                        {{ method_field('DELETE') }}
                                                        <button class="btn btn-default btn-sm" aria-label="delete file"
                                                                onclick="return confirm('Are you sure you want to delete this file?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16"
                                                                 fill="currentColor" class="bi bi-trash"
                                                                 viewBox="0 0 16 16">
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

                                            <p class="card-text mt-2">{{$comment->comment_text}}  </p>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                            @endif
                        </div>

                        <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12">

                            <div>
                                <div class="col-md-12">
                                    <div class="card-body border border-dark">
                                        <label for="commentText" class="form-label"><h5>Leave a comment</h5></label>
                                        <form method="POST" action={{route('add.comment')}}>
                                            @csrf
                                            <div class="form-group">
                                                <div class="mb-3">
                                     <textarea type="text" id="commentText" name="comment" rows=3 cols=2
                                               class="form-control"
                                               id="commentText">{{old('comment')}}</textarea>
                                                </div>
                                                <input type="hidden" name="file_id" value="{{ $details->id }}"/>
                                            </div>

                                            <button type="submit" name="submit" class="btn btn-success btn-block mt-2">
                                                Post Comment
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </section>



    @endif

@endsection
