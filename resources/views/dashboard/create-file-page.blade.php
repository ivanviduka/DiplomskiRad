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
                <div class="card border-2 border-dark">
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
                                <label for="selectedFile" class="form-label"> <strong>Select file </strong></label>
                                <input type="file" name="file" class="form-control" id="selectedFile">
                            </div>

                            <div class="mb-2">
                                @if ($errors->has('file'))
                                    <span class="text-danger">{{ $errors->first('file') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="fileDescription" class="form-label"><strong>Add file
                                        description</strong></label>
                                <textarea type="text" name="description" rows=3 cols=2 class="form-control"
                                          id="fileDescription">{{old('description')}}</textarea>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" {{old('is_public') ? "checked" : ""}}
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

                            <div>
                                @if ($errors->has('subject_id'))
                                    <span class="text-danger mt-2 mb-2">{{ $errors->first('subject_id') }}</span>
                                @endif
                            </div>

                            <button type="submit" name="submit" class="btn btn-success btn-block mt-4">
                                Upload File
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


