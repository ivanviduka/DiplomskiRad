@extends('layouts.header')

@section('title')
    <title>Public files</title>
@endsection

@section('description')
    <meta name="description" content="Homepage with shared public files">
@endsection

@section('content')

    @if (count($files) > 0)
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">

                    <thead>
                    <th scope="col">File</th>
                    <th scope="col">Description</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Owner</th>
                    <th scope="col"></th>
                    </thead>

                    <tbody>
                    @foreach ($files as $file)

                        <tr>
                            <td class="table-text">
                                <a href="#">{{ $file->user_file_name }}</a>

                                @if(auth()->user()->is_admin)
                                    <form action="{{route('delete.file', [$file])}}" method="POST">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-default btn-sm"
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
                            </td>

                            <td class="table-text">
                                <div>{{ $file->description }}</div>
                            </td>

                            <td class="table-text">
                                <div>{{ $file->subject->subject_name}}</div>
                            </td>

                            <td class="table-text">
                                <div>{{ $file->user->email }}</div>
                            </td>

                            <td>More info</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="container">
            <div class="alert alert-dark d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                     class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                     aria-label="Warning:">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0
                        1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1
                        5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <div>
                    There are no uploaded public files</a>.
                </div>
            </div>
        </div>
    @endif
@endsection





