@extends('layouts.header')

@section('title')
    <title>Add file</title>
@endsection

@section('description')
    <meta name="description" content="Page with form for adding new files">
@endsection

@section('content')

    <div class="container mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card border-2 border-primary">
                    <div class="card-body">
                        <form action="{{route('add.file')}}" method="post" enctype="multipart/form-data">
                            <h3 class="text-center mb-5">Upload File to FERIT Share</h3>
                            @csrf

                            @if(session()->has('message'))
                                <div class="alert alert-danger ms-3 me-3" role="alert">
                                    {{session()->get('message')}}
                                </div>
                            @endif

                            <div class="custom-file mb-3">
                                <label for="selectedFile" class="form-label">Select file</label>
                                <input type="file" name="file" class="form-control" id="selectedFile">
                            </div>

                            <div class="mb-3">
                                <label for="selectedFile" class="form-label">Add file description</label>
                                <textarea type="text" name="description" rows=3 cols=2 class="form-control"
                                          id="fileDescription"> {{old('is_public')}} </textarea>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="{{old('is_public')}}"
                                       name="is_public" id="public_check">
                                <label class="form-check-label" for="public_check">
                                    Make file public
                                </label>
                            </div>

                            <select style="width:auto;" class="form-select me-4 mb-2"
                                    name="subject_id" aria-label="Subject selection">
                                <option value="#" selected>Choose subject</option>
                                @foreach($subjects as $subject)
                                    <option value={{$subject->id}}> {{$subject->subject_name}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('subject_id'))
                                <span class="text-danger mt-2 mb-2">{{ $errors->first('subject_id') }}</span>
                            @endif

                            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                                Upload File
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


