@extends('layouts.header')

@section('title')
    <title>Search</title>
@endsection

@section('description')
    <meta name="description" content="Search file form page">
@endsection

@section('content')

    <div class="container mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card border-2 border-dark">
                    <div class="card-body">
                        <form method="GET" enctype="multipart/form-data" action="{{ route('search.results') }}">
                            <h3 class="text-center mb-5">Search files</h3>
                            <div class="mb-3">
                                <label for="fileName" class="form-label"><strong>File Name</strong></label>
                                <input type="text" name="user_file_name" class="form-control" id="fileName">
                            </div>

                            <div>
                                @if ($errors->has('user_file_name'))
                                    <span class="text-danger mt-2 mb-2">{{ $errors->first('user_file_name') }}</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label"><strong>User email</strong></label>
                                <input type="text" name="email" class="form-control" id="email">
                            </div>

                            <div>
                                @if ($errors->has('email'))
                                    <span class="text-danger mt-2 mb-2">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <select style="width:auto;" class="form-select me-4 mb-3"
                                    name="subject_id" aria-label="Subject selection">
                                <option value="" selected>Subject</option>
                                @foreach($subjects as $subject)
                                    <option value={{$subject->id}}> {{$subject->subject_name}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('subject_id'))
                                <span class="text-danger mt-2 mb-2">{{ $errors->first('subject_id') }}</span>
                            @endif

                            <select style="width:auto;" class="form-select me-4 mb-3"
                                    name="year_of_study" aria-label="Year of study selection">
                                <option value="" selected>Year of study</option>
                                @foreach($years as $year)
                                    <option value={{$year->year_of_study}}> {{$year->year_of_study}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('year_of_study'))
                                <span class="text-danger mt-2 mb-2">{{ $errors->first('year_of_study') }}</span>
                            @endif

                            <select style="width:auto;" class="form-select me-4 mb-2"
                                    name="major_id" aria-label="Category selection">
                                <option value="" selected>Major</option>
                                @foreach($majors as $major)
                                    <option value={{$major->major_id}}> {{$major->major_name}}</option>
                                @endforeach

                            </select>

                            @if ($errors->has('major_id'))
                                <span class="text-danger mt-2 mb-2">{{ $errors->first('major_id') }}</span>
                            @endif

                            <button class="btn btn-success" type="submit">Search
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-search ms-1" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1
                                     1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12
                                      6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
