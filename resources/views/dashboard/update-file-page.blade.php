@extends('layouts.header')

@section('title')
    <title>Update file</title>
@endsection

@section('description')
    <meta name="description" content="Page with form for updating user file">

@endsection

@section('content')

    <div class="container mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card border-2 border-dark">
                    <div class="card-body">
                        <form class="form" action="{{ route('update.file', [$file]) }}" method="post"
                              enctype="multipart/form-data">
                            <h2 class="text-center mb-5">Update file</h2>
                            @csrf
                            @method('PUT')

                            @if(session()->has('message'))
                                <div class="alert alert-danger ms-3 me-3" role="alert">
                                    {{session()->get('message')}}
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="fileName" class="form-label"><strong>File Name</strong></label>
                                <input type="text" name="user_file_name" value="{{$file->user_file_name}}"
                                       class="form-control"
                                       id="fileName">
                            </div>

                            <div>
                                @if ($errors->has('user_file_name'))
                                    <span class="text-danger mt-2 mb-2">{{ $errors->first('user_file_name') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="fileDescription" class="form-label"><strong>File
                                        description</strong></label>
                                <textarea type="text" name="description" rows=3 cols=2 class="form-control"
                                          id="fileDescription">{{$file->description}}</textarea>
                            </div>

                            <div>
                                @if ($errors->has('description'))
                                    <span class="text-danger mt-2 mb-2">{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" {{$file->is_public ? "checked" : ""}}
                                name="is_public" id="public_check">
                                <label class="form-check-label" for="public_check">
                                    Make file public
                                </label>
                            </div>

                            <select style="width:auto;" class="form-select me-4 mb-2" name="subject_id"
                                    aria-label="Subject selection">

                                <option value="#">Choose subject</option>
                                @foreach($subjects as $subject)
                                    <option
                                        value={{$subject->id}} {{$file->subject_id == $subject->id ? "selected" : ""}}>
                                        {{$subject->subject_name}}
                                    </option>
                                @endforeach

                            </select>

                            <div>
                                @if ($errors->has('subject_id'))
                                    <span class="text-danger mt-2 mb-2">{{ $errors->first('subject_id') }}</span>
                                @endif
                            </div>

                            <button type="submit" name="submit" class="btn btn-success btn-block mt-4">
                                Update File
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


