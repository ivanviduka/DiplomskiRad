@extends('layouts.header')

@section('title')
    <title>My files</title>
@endsection

@section('description')
    <meta name="description" content="Page with all user files">
@endsection

@section('content')

    @if (count($files) > 0)
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">

                    <thead>
                    <th scope="col">File </th>
                    <th scope="col"></th>
                    <th scope="col">Description</th>
                    <th scope="col">Subject</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    </thead>

                    <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td class="table-text">
                                <a href="#">{{ $file->user_file_name }}</a>
                            </td>

                            @if($file->is_public)
                                <td class="table-text">
                                    <form action="/share/{{ $file->id }}" method="GET">
                                        <button class="btn btn-default btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor"
                                                 class="bi bi-share" viewBox="0 0 16 16">
                                                <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11
                                        2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0
                                        1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5
                                        0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5
                                        0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0
                                        3 1.5 1.5 0 0 0 0-3z"/>
                                            </svg>
                                        </button>
                                    </form>

                                </td>
                            @else
                                <td></td>
                            @endif

                            <td class="table-text">
                                <div>{{ $file->description }}</div>
                            </td>

                            <td class="table-text">
                                <div>{{ $file->subject->subject_name}}</div>
                            </td>

                            <td>
                                <form action="{{route('update-file.form', [$file])}}" method="GET">
                                    <button class="btn btn-outline-secondary">Alter File</button>
                                </form>


                            </td>

                            <td>
                                <form action="{{route('delete.file', [$file])}}" method="POST">
                                    @csrf
                                    {{ method_field('DELETE') }}

                                    <button class="btn btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this file?')">Delete File</button>
                                </form>
                            </td>
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
                    You don't have any stored files. <a href="{{route('create-file.form')}}" class="alert-link">Add your
                        first file </a>.
                </div>
            </div>
        </div>
    @endif
@endsection


